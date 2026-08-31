@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <h1>Halaman Penjualan</h1>

    <!-- Tombol Create -->
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

    <!-- Form Search -->
    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input 
                type="text"
                name="search"
                value="{{ request()->search }}"
                class="form-control"
                placeholder="Search penjualan"
            >
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
        </div>
    </form>

    <!-- Tabel Data Penjualan -->
    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Kasir</th>
                <th scope="col">Total Pembayaran</th>
                <th scope="col">Metode Pembayaran</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <th scope="row">{{ $sales->firstItem() + $loop->index }}</th>
                {{-- Penulisan translatedFormat yang benar (menggunakan huruf t) --}}
                <td>{{ $sale->created_at?->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $sale->user?->name ?? 'User Tidak Ditemukan' }}</td>
                <td>Rp. {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
                <td>{{ $sale->metode_pembayaran }}</td>
                <td>{{ $sale->status }}</td>
                <td>
                    <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-primary">Detail</a>
                    <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $sales->links() }}
    </div>
</div>

@endsection