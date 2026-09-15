@extends('layouts.app')

@section('title','Penjualan')

@section('content')

<style>
    h1 {
        color: #2c3e50;
    }

    .table thead th {
        background-color: #4e73df !important;
        color: #ffffff !important;
    }

    .table > tbody > tr:nth-child(even) > td {
        background-color: #f2f6fc !important;
    }

    .table > tbody > tr:hover > td {
        background-color: #dce6f7 !important;
    }
</style>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<h1>Halaman Penjualan</h1>

<a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search penjualan"
        >
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Transaksi</th>
            <th>Kasir</th>
            <th>Total Pembayaran</th>
            <th>Metode Pembayaran</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sales as $sale)
        <tr>
            <td>{{ $sales->firstItem() + $loop->index }}</td>
            <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
            <td>{{ $sale->user->name }}</td>
            <td>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
            <td>{{ $sale->metode_pembayaran }}</td>
            <td>{{ $sale->status }}</td>
            <td class="d-flex gap-1">
                <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-primary btn-sm">Detail</a>

                {{-- TOMBOL CETAK STRUK (Hanya muncul jika status COMPLETED) --}}
           

                @if($sale->status === 'OPEN' && Auth::user()->role->name === 'admin')
                <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                        Hapus
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $sales->links() }}

@endsection