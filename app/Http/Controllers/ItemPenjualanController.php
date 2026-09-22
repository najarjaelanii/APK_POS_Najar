<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Produk::findOrFail($request->product_id);

        // ❗️ Cek stok sebelum transaksi
        if ($product->stok < $request->quantity) {
            return back()->withErrors('Stok produk tidak mencukupi');
        }

        DB::transaction(function () use ($request, $product) {
            $sale = Penjualan::where('user_id', Auth::id())
                ->where('status', 'OPEN')
                ->firstOrFail();

            // Lock produk untuk penanganan race condition
            $product = Produk::lockForUpdate()->find($product->id);

            // 🔽 Kurangi stok
            $product->decrement('stok', $request->quantity);

            // ➕ Update / insert item penjualan
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                // UPDATE
                $item->kuantitas += $request->quantity;
            } else {
                // CREATE
                $item = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->quantity,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            // Hitung subtotal SETELAH kuantitas fix
            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            // 🔢 TOTAL PEMBAYARAN
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back()->with('success', 'Item berhasil ditambahkan');
    }

    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $selisih = $request->quantity - $itempenjualan->kuantitas;
        $produk  = $itempenjualan->produk;

        // 🔍 Jika qty bertambah -> Cek ketersediaan stok sebelum transaksi
        if ($selisih > 0 && $produk->stok < $selisih) {
            return back()->withErrors('Stok produk tidak mencukupi');
        }

        DB::transaction(function () use ($request, $itempenjualan, $selisih) {
            $produk = $itempenjualan->produk()->lockForUpdate()->first();

            // 🔍 Jika qty bertambah -> kurangi stok
            if ($selisih > 0) {
                $produk->decrement('stok', $selisih);
            }

            // 🔍 Jika qty berkurang -> kembalikan stok
            if ($selisih < 0) {
                $produk->increment('stok', abs($selisih));
            }

            // 🔄 Update item
            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
            ]);

            // 🔄 Update total penjualan
            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Jumlah item berhasil diperbarui');
    }

    public function destroy(ItemPenjualan $itempenjualan)
    {
        // Otorisasi $this->authorize('delete', $itempenjualan) dihapus agar tidak muncul error 403

        DB::transaction(function () use ($itempenjualan) {
            $produk = $itempenjualan->produk()->lockForUpdate()->first();
            $sale   = $itempenjualan->penjualan;

            // ⏫ Kembalikan stok
            if ($produk) {
                $produk->increment('stok', $itempenjualan->kuantitas);
            }

            // ❌ Hapus item
            $itempenjualan->delete();

            // 🔄 Update total penjualan
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Item berhasil dihapus');
    }
}