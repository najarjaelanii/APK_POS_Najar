<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\User\SearchRequest as UserSearchRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserSearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        // Memuat relasi 'user' menggunakan with('user')
        $products = Produk::with('user')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create',Produk::class);

        $dataReq = $request->validated();

        $data['user_id']    = Auth::id();
        $data['nama']       = $dataReq['nama'] ?? $dataReq['name'] ?? null;
        $data['harga_beli'] = $dataReq['harga_beli'] ?? $dataReq['purchase_price'] ?? 0;
        $data['harga_jual'] = $dataReq['harga_jual'] ?? $dataReq['selling_price'] ?? 0;
        $data['stok']       = $dataReq['stok'] ?? $dataReq['stock'] ?? 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('Update', $produk);

        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama (jika ada & memang tersimpan)
            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        // PERBAIKAN: Mengarah ke halaman index produk (atau bisa diubah ke 'admin.produk.edit' jika ingin tetap di halaman edit)
        return redirect()->route('produk.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);
        
        // Fitur hapus foto saat data produk dihapus
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Product deleted successfully.');
    }
}