{{-- memanggil file app.blade.php --}}
@extends('layouts.app')
 
{{-- mengirimkan nilai ke title untuk ditampilkan --}}
@section('title', 'Dashboard')
 
{{-- batas awal isi konten --}}
@section('content')
 
@include('layouts.navbar')
 
<style>
    :root {
        --ink:         #1E2530;
        --ink-light:   #2A3341;
        --paper:       #F5F6F4;
        --brass:       #C79A5B;
        --muted:       #9CA3B0;
        --warn-soft:   #FBEEE2;
        --warn:        #B5652E;
        --danger-soft: #F7E7E5;
        --danger:      #A23B34;
    }
 
    body { background: var(--paper); }
 
    .dash-page-title {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 2rem;
    }
    .dash-page-title small {
        display: block;
        font-family: inherit;
        font-weight: 400;
        font-size: .95rem;
        color: #767D89;
        margin-top: 4px;
    }
 
    .dash-section-title {
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink);
        margin: 2rem 0 .9rem;
    }
 
    /* ---- kartu dasar gelap, dipakai bersama oleh stat-card & table-card ---- */
    .stat-card,
    .table-card {
        background: linear-gradient(155deg, var(--ink) 0%, var(--ink-light) 100%);
        border-radius: 12px;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .stat-card::after,
    .table-card::after {
        content: "";
        position: absolute;
        right: -26px; top: -26px;
        width: 110px; height: 110px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(199,154,91,.22), transparent 70%);
        pointer-events: none;
    }
 
    .stat-card { padding: 22px; }
    .stat-label {
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 6px;
        font-weight: 500;
        position: relative;
    }
    .stat-value {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        font-size: 1.5rem;
        color: #fff;
        position: relative;
    }
 
    /* ---- table card ---- */
    .table-card-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        font-weight: 600;
        color: #fff;
        font-size: .92rem;
        position: relative;
    }
 
    .table-responsive {
        background-color: transparent;
    }
    .dash-table,
    .dash-table > :not(caption) > * > * {
        /* mematikan background putih bawaan Bootstrap pada table & sel */
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-color: #E7E9EC;
        --bs-table-striped-bg: transparent;
        --bs-table-hover-bg: rgba(255,255,255,.05);
    }
    .dash-table {
        margin-bottom: 0;
        position: relative;
    }
    .dash-table thead th {
        color: var(--muted);
        font-weight: 600;
        border-bottom: 1px solid rgba(255,255,255,.08);
        font-size: .72rem;
        letter-spacing: .02em;
    }
    .dash-table td, .dash-table th {
        vertical-align: middle;
        padding: 11px 20px;
        font-size: .87rem;
        border-color: rgba(255,255,255,.08);
        color: #E7E9EC;
    }
    .dash-table tbody tr:hover { background-color: rgba(255,255,255,.05) !important; }
    .dash-table .text-muted { color: var(--muted) !important; }
    .dash-table .fw-semibold { color: #fff; }
 
    /* pagination link di dalam kartu gelap */
    .table-card .pagination .page-link {
        background: transparent;
        border-color: rgba(255,255,255,.12);
        color: #E7E9EC;
    }
    .table-card .pagination .page-item.disabled .page-link {
        background: transparent;
        color: var(--muted);
    }
    .table-card .pagination .page-item.active .page-link {
        background: var(--brass);
        border-color: var(--brass);
        color: var(--ink);
    }
 
    .badge-warning-soft {
        background-color: var(--warn-soft);
        color: var(--warn);
        font-weight: 600;
        font-size: .74rem;
        padding: 3px 10px;
        border-radius: 100px;
    }
    .badge-danger-soft {
        background-color: var(--danger-soft);
        color: var(--danger);
        font-weight: 600;
        font-size: .74rem;
        padding: 3px 10px;
        border-radius: 100px;
    }
 
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&display=swap');
</style>
 
<div class="container my-4">
 
    <div class="dash-page-title text-center">
        Ringkasan Hari Ini
        <small>({{ $tanggalHariIni->translatedFormat('l, d F Y') }})</small>
    </div>
 
    @can('viewAny', App\Models\User::class)
    <div class="dash-section-title">Penjualan Hari Ini</div>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Nilai Penjualan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <div class="stat-label">Jumlah Transaksi Hari Ini</div>
                <div class="stat-value">{{ $ringkasan['total_transaksi'] }}</div>
            </div>
        </div>
    </div>
    @endcan
 
    <div class="dash-section-title">Status Kas & Pembayaran</div>
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
 
    <div class="dash-section-title">Status Stok Kritis</div>
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
                                <td colspan="3" class="text-muted text-center py-4">
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
                                <td colspan="3" class="text-muted text-center py-4">
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
 
    <div class="dash-section-title">Produk Terlaris</div>
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
                        <td colspan="3" class="text-muted text-center py-4">
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