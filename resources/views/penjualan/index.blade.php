@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --shop-blue: #2e6de0;
        --shop-blue-dark: #1e52b8;
        --shop-blue-light: #eaf1fd;
    }

    .shopee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 12px;
    }

    .shopee-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .btn-shopee {
        background-color: var(--shop-blue);
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 4px;
        transition: background-color .15s ease-in-out;
    }
    .btn-shopee:hover {
        background-color: var(--shop-blue-dark);
        color: #fff;
    }

    .shopee-search {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 6px;
        margin-bottom: 1.5rem;
    }
    .shopee-search input {
        border: none;
        box-shadow: none;
    }
    .shopee-search input:focus {
        box-shadow: none;
    }
    .shopee-search .btn-search {
        background-color: var(--shop-blue);
        color: #fff;
        border-radius: 3px;
        font-weight: 600;
        padding: 6px 24px;
    }
    .shopee-search .btn-search:hover {
        background-color: var(--shop-blue-dark);
        color: #fff;
    }

    .sales-table-wrap {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #eee;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .sales-table thead th {
        background-color: var(--shop-blue-light);
        color: #1e3a6e;
        font-weight: 600;
        border-bottom: none;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .sales-table tbody tr {
        transition: background-color .15s ease;
    }
    .sales-table tbody tr:hover {
        background-color: #f7faff;
    }

    .sales-table td, .sales-table th {
        vertical-align: middle;
        padding: 12px 14px;
    }

    .badge-status {
        font-size: .75rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-block;
    }
    .badge-status.completed {
        background-color: #e2f6ea;
        color: #1e8a4c;
    }
    .badge-status.open {
        background-color: #fff3cd;
        color: #a5730a;
    }

    .action-btns {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .action-btns .btn {
        font-size: .78rem;
        padding: 4px 12px;
        border-radius: 4px;
    }
    .btn-detail {
        background-color: var(--shop-blue);
        color: #fff;
        border: none;
    }
    .btn-detail:hover {
        background-color: var(--shop-blue-dark);
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 50px 0;
        color: #999;
    }
</style>

<div class="container my-4">

    <div class="shopee-header">
        <h1> Halaman Penjualan</h1>
        <a href="{{ route('penjualan.create') }}" class="btn btn-shopee">Create</a>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Search -->
    <form action="{{ route('penjualan.index') }}" method="GET">
        <div class="input-group shopee-search">
            <input
                type="text"
                name="search"
                value="{{ request()->search }}"
                class="form-control"
                placeholder="Cari penjualan..."
            >
            <button class="btn btn-search" type="submit">
                 Cari
            </button>
        </div>
    </form>

    <!-- Tabel Data Penjualan -->
    <div class="sales-table-wrap">
        <div class="table-responsive">
            <table class="table sales-table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kasir</th>
                        <th scope="col">Total Pembayaran</th>
                        <th scope="col">Metode Pembayaran</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <th scope="row">{{ $sales->firstItem() + $loop->index }}</th>
                        <td>{{ optional($sale->created_at)->translatedFormat('d-m-Y H:i:s') }}</td>
                        <td>{{ $sale->user->name ?? '-' }}</td>
                        <td class="fw-semibold">Rp {{ number_format($sale->total_pembayaran) }}</td>
                        <td>{{ $sale->metode_pembayaran ?? '-' }}</td>
                        <td>
                            @if($sale->status === 'COMPLETED')
                                <span class="badge-status completed">COMPLETED</span>
                            @else
                                <span class="badge-status open">OPEN</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-detail">Detail</a>

                                @can('view', $sale)
                                    <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning">Edit</a>
                                @endcan

                                @can('delete', $sale)
                                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('Apakah anda yakin ingin membatalkan/menghapus penjualan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div style="font-size: 3rem;"></div>
                                <p>Data penjualan tidak ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        {{ $sales->links() }}
    </div>
</div>

@endsection