@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h3 class="fw-bold text-dark mb-0">Halaman Penjualan</h3>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary px-4">Create</a>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Search -->
    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="search"
                value="{{ request()->search }}"
                class="form-control"
                placeholder="Cari penjualan..."
            >
            <button class="btn btn-primary px-4" type="submit">Search</button>
        </div>
    </form>

    <!-- Tabel Data Penjualan -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr style="background-color:#eaf1fd;">
                        <th class="ps-3 py-3 text-primary text-uppercase small fw-semibold">#</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold">Tanggal Transaksi</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold">Kasir</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold">Total Pembayaran</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold">Metode Pembayaran</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold">Status</th>
                        <th class="py-3 text-primary text-uppercase small fw-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td class="ps-3 text-danger fw-semibold">{{ $sales->firstItem() + $loop->index }}</td>
                        <td>{{ optional($sale->created_at)->translatedFormat('d-m-Y H:i:s') }}</td>
                        <td>{{ $sale->user->name ?? '-' }}</td>
                        <td class="fw-semibold">Rp {{ number_format($sale->total_pembayaran) }}</td>
                        <td>{{ $sale->payment_method ?? '-' }}</td>
                        <td>
                            @if($sale->status === 'COMPLETED')
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">COMPLETED</span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">OPEN</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-primary btn-sm px-3">Detail</a>

                                @can('view', $sale)
                                    <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning btn-sm px-3">Edit</a>
                                @endcan

                                @can('delete', $sale)
                                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm px-3"
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
                            <div class="text-center text-muted py-5">
                                <p class="mb-0">Data penjualan tidak ditemukan.</p>
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