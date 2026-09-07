{{-- memanggil file app.blade.php --}}
@extends('layouts.app')

{{-- mengirimkan nilai ke title untuk ditampilkan --}}
@section('title', 'Dashboard')

{{-- batas awal isi konten --}}
@section('content')

@include('layouts.navbar')

<style>
    :root {
        --shop-blue: #1c1e22;
        --shop-blue-dark: #25272c;
        --shop-blue-light: #eaf1fd;
    }

    .dash-page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 1.75rem;
    }
    .dash-page-title small {
        font-weight: 400;
        font-size: 1rem;
        color: #888;
    }

    .dash-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--shop-blue);
        margin: 1.75rem 0 1rem;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        height: 100%;
        transition: box-shadow .2s ease;
    }
    .stat-card:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .stat-label {
        font-size: .82rem;
        color: #888;
        margin-bottom: 4px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #222;
    }
    .stat-value.blue { color: var(--shop-blue); }

    .table-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        height: 100%;
    }
    .table-card-header {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 700;
        color: var(--shop-blue);
        font-size: .95rem;
    }

    .dash-table thead th {
        background-color: var(--shop-blue-light);
        color: var(--shop-blue);
        font-weight: 600;
        border-bottom: none;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .3px;
    }
    .dash-table td, .dash-table th {
        vertical-align: middle;
        padding: 10px 14px;
        font-size: .9rem;
    }
    .dash-table tbody tr:hover {
        background-color: #f7faff;
    }

    .badge-warning-soft {
        background-color: #fff3cd;
        color: #a5730a;
        font-weight: 600;
        font-size: .75rem;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .badge-danger-soft {
        background-color: #fdeaea;
        color: #c0392b;
        font-weight: 600;
        font-size: .75rem;
        padding: 3px 10px;
        border-radius: 20px;
    }
</style>

<div class="container my-4">

    <div class="dash-page-title text-center">
        Ringkasan Hari Ini
        <small>({{ $tanggalHariIni->translatedFormat('l, d F Y') }})</small>
    </div>

    @can('viewAny', App\Models\User::class)
    <div class="dash-section-title">Today's Sales</div>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Nilai Penjualan Hari Ini</div>
                <div class="stat-value blue">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Jumlah Transaksi Hari Ini</div>
                <div class="stat-value"> {{ $ringkasan['total_transaksi'] }}</div>
            </div>
        </div>
    </div>
    @endcan

    <div class="dash-section-title">Cash & Payment Status</div>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Pembayaran Tunai</div>
                <div class="stat-value">Rp {{ number_format($ringkasan['total_cash']) }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Pembayaran Non-Tunai</div>
                <div class="stat-value">Rp {{ number_format($ringkasan['total_non_tunai']) }}</div>
            </div>
        </div>
    </div>

    <div class="dash-section-title">Critical Inventory Status</div>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="table-card">
                <div class="table-card-header">Daftar Produk Stok Rendah</div>
                <div class="table-responsive">
                    <table class="table dash-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokRendah as $index => $produk)
                            <tr>
                                <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                <td>{{ $produk->nama }}</td>
                                <td><span class="badge-warning-soft">{{ $produk->stok }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-3">
                                    Seluruh produk berada dalam kondisi stok aman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-2">
                    {{ $produkStokRendah->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="table-card">
                <div class="table-card-header">Produk Habis Stok</div>
                <div class="table-responsive">
                    <table class="table dash-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokHabis as $index => $produk)
                            <tr>
                                <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                                <td>{{ $produk->nama }}</td>
                                <td><span class="badge-danger-soft">{{ $produk->stok }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-3">
                                    Seluruh produk berada dalam kondisi stok aman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-2">
                    {{ $produkStokHabis->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="dash-section-title">Best Seller Products</div>
    <div class="table-card mb-3">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Unit Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkTerlaris as $produk)
                    <tr>
                        <td>{{ $produk->nama }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td class="fw-semibold">{{ $produk->total_terjual }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted text-center py-3">
                            Belum ada data transaksi produk terlaris.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- batas akhir isi konten --}}
@endsection