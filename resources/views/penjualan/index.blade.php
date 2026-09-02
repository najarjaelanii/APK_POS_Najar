@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <h1 class="mb-4">Halaman Penjualan</h1>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ is_object(session('errors')) ? session('errors')->first() : session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                placeholder="Search penjualan..."
            >
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
        </div>
    </form>

    <!-- Tabel Data Penjualan -->
    <div class="table-responsive">
        <table class="table align-middle table-hover border">
            <thead class="table-light">
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
                    <td>Rp {{ number_format($sale->total_pembayaran) }}</td>
                    <td>{{ $sale->metode_pembayaran ?? '-' }}</td>
                    <td>
                        @if($sale->status === 'COMPLETED')
                            <span class="badge bg-success">COMPLETED</span>
                        @else
                            <span class="badge bg-warning text-dark">OPEN</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                        
                        {{-- Tombol Edit / Lanjutkan Transaksi jika masih OPEN --}}
                        <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Apakah anda yakin ingin membatalkan/menghapus penjualan ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Data Tidak Ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        {{ $sales->links() }}
    </div>
</div>

@endsection