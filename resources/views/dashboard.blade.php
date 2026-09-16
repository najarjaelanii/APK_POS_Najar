<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<style>
    .page-heading {
        color: #1e293b !important;
        font-weight: 700;
    }

    .page-heading small {
        font-weight: 400;
        font-size: 1rem;
        color: #64748b !important;
    }

    .section-title {
        color: #334155 !important;
        font-weight: 600;
        font-size: 1.15rem;
        margin: 2rem 0 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .section-title::before {
        content: "";
        width: 4px;
        height: 20px;
        background-color: #0d6efd;
        border-radius: 2px;
        display: inline-block;
    }

    /* ===== Kartu Statistik ===== */
    .container .stat-card.card {
        background-color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06) !important;
        overflow: hidden;
        height: 100%;
    }

    .container .stat-card .card-header {
        background-color: #0d6efd !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none !important;
        padding: .75rem 1.25rem;
    }

    .container .stat-card .card-body {
        background-color: #ffffff !important;
        padding: 1.25rem;
    }

    .container .stat-card .card-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e293b !important;
        margin-bottom: 0;
    }

    /* ===== Kartu Panel (tabel) ===== */
    .container .panel-card {
        background-color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06) !important;
        padding: 1.25rem;
        height: 100%;
        color: #1e293b;
    }

    .container .panel-card h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #334155 !important;
        margin-bottom: 1rem;
    }

    /* ===== Tabel ===== */
    .container .panel-card .table,
    .container .panel-card .table td,
    .container .panel-card .table th {
        background-color: #ffffff !important;
        color: #1e293b !important;
    }

    .container .panel-card .table thead th {
        background-color: #eaf1fd !important;
        color: #0d6efd !important;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none !important;
        padding: .65rem .75rem;
    }

    .container .panel-card .table tbody td {
        padding: .65rem .75rem;
        vertical-align: middle;
        border-color: #f1f5f9 !important;
    }

    .container .panel-card .table tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    .badge-stok {
        font-weight: 600;
        font-size: .75rem;
        padding: .35em .65em;
        border-radius: 6px;
    }

    .badge-stok-rendah {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }

    .badge-stok-habis {
        background-color: #f8d7da !important;
        color: #842029 !important;
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: #eaf1fd;
        color: #0d6efd;
        font-size: .75rem;
        font-weight: 700;
        margin-right: .5rem;
    }

    .empty-state {
        color: #94a3b8 !important;
        font-style: italic;
    }
</style>

    <div class="container py-3">

        <div class="text-center mb-4">
            <h1 class="page-heading">
                Ringkasan hari ini
                <small class="text-muted d-block d-md-inline">
                    ({{ $tanggalHariIni->translatedFormat('l, d F Y') }})
                </small>
            </h1>
        </div>

        <!-- Today's Sales -->
        <div class="section-title">Today's Sales</div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-header">Total Nilai Penjualan Hari Ini</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_penjualan']) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-header">Jumlah Transaksi Hari Ini</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $ringkasan['total_transaksi'] }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash & Payment Status -->
        <div class="section-title">Cash & Payment Status</div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-header">Total Pembayaran Tunai</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_cash']) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-header">Total Pembayaran Non-Tunai</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp {{ number_format($ringkasan['total_non_tunai']) }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Critical Inventory Status -->
        <div class="section-title">Critical Inventory Status</div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="panel-card">
                    <h3>Daftar Produk Stok Rendah</h3>
                    <table class="table">
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
                                    <td><span class="badge-stok badge-stok-rendah">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state text-center py-3">
                                        Seluruh produk berada dalam stok aman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $produkStokRendah->links() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel-card">
                    <h3>Produk Habis Stok</h3>
                    <table class="table">
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
                                    <td><span class="badge-stok badge-stok-habis">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state text-center py-3">
                                        Seluruh produk berada dalam stok aman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $produkStokHabis->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Best Seller Product -->
        <div class="section-title">Best Seller Product</div>
        <div class="row g-3 mb-4">
            <div class="col-md-12">
                <div class="panel-card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Unit Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkTerlaris as $index => $produk)
                                <tr>
                                    <td><span class="rank-badge">{{ $index + 1 }}</span>{{ $produk->nama }}</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>{{ $produk->total_terjual }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state text-center py-3">
                                        Seluruh produk berada dalam kondisi stok aman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- batas akhir isi konten -->
@endsection