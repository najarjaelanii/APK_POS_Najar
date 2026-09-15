<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $penjualan->id }}</title>
    <style>
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 20px 0;
            display: flex;
            justify-content: center;
        }
        .struk {
            width: 58mm;
            padding: 5px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
        }
        table {
            width: 100%;
            font-size: 11px;
        }
        @media print {
            body {
                width: 58mm;
                padding: 0;
                display: block;
            }
            .struk {
                width: 58mm;
                margin: 0 auto;
            }
            .no-print {
                display: none;
            }
            @page { margin: 0; size: 58mm auto; }
        }

        .btn-action {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            padding: 6px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 6px;
        }
        .btn-print {
            background-color: #4e73df;
            color: #fff;
        }
        .btn-print:hover {
            background-color: #3d5fc4;
        }
        .btn-back {
            background-color: #eef1fb;
            color: #4e73df;
            border: 1px solid #4e73df;
        }
        .btn-back:hover {
            background-color: #e0e6fa;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="struk">

        <div class="text-center">
            <span class="fw-bold" style="font-size: 14px;">POS NAZWA</span>
        </div>

        <div class="divider"></div>

        <div>
            No Transaksi : #{{ $penjualan->id }}<br>
            Tanggal      : {{ $penjualan->created_at->format('d/m/Y H:i') }}<br>
            Kasir        : {{ $penjualan->user->name }}<br>
            Pembayaran   : {{ $penjualan->metode_pembayaran }}
        </div>

        <div class="divider"></div>

        <table>
            @foreach($penjualan->itemPenjualan as $item)
            <tr>
                <td colspan="3">{{ $item->produk->nama }}</td>
            </tr>
            <tr>
                <td>{{ $item->kuantitas }} x {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td></td>
                <td class="text-right">{{ number_format($item->harga_satuan * $item->kuantitas, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>

        <div class="divider"></div>

        <table>
            <tr>
                <td class="fw-bold">Total</td>
                <td class="text-right fw-bold">Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="text-center">
            <span>Terima Kasih Atas Kunjungan Anda!</span><br>
            <span>Barang yang sudah dibeli tidak dapat ditukar</span>
        </div>

        <div class="text-center no-print" style="margin-top: 15px;">
            <button onclick="window.print()" class="btn-action btn-print">Cetak Lagi</button><br>
            <a href="{{ route('penjualan.index') }}" class="btn-action btn-back">Kembali</a>
        </div>

    </div>

</body>
</html>