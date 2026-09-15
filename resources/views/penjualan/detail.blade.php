@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

@include('layouts.navbar')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 mt-3">
        <div>
            <h3 class="fw-bold mb-1">Detail Transaksi #{{ $sale->id }}</h3>
            <p class="text-muted small mb-0">{{ optional($sale->created_at)->translatedFormat('d-m-Y H:i:s') }}</p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- ================== INFORMASI TRANSAKSI ================== --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-primary text-white fw-semibold py-3 rounded-top-3">
                    Informasi Transaksi
                </div>
                <div class="card-body p-4">

                    <div class="mb-3">
                        <div class="text-muted small">Kasir</div>
                        <div class="fw-semibold">{{ $sale->user->name ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Status</div>
                        @if($sale->status === 'COMPLETED')
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Selesai</span>
                        @else
                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">Open</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Metode Pembayaran</div>
                        <div class="fw-semibold">
                            <i class="bi bi-credit-card text-primary"></i> {{ strtoupper($sale->payment_method ?? '-') }}
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="text-muted small">Total Pembayaran</div>
                        <div class="fs-4 fw-bold text-primary">Rp {{ number_format($sale->total_pembayaran) }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Bayar (Tunai)</div>
                        <div class="fw-semibold">
                            Rp {{ number_format($sale->cash_amount ?? $sale->total_pembayaran) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small">Kembalian</div>
                        <div class="fw-semibold text-success">
                            Rp {{ number_format($sale->kembalian ?? 0) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================== ITEM DIBELI ================== --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white fw-semibold py-3 rounded-top-3">
                    Item Dibeli
                </div>
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr style="background-color:#eaf1fd;">
                                    <th class="text-primary text-uppercase small fw-semibold">#</th>
                                    <th class="text-primary text-uppercase small fw-semibold">Produk</th>
                                    <th class="text-primary text-uppercase small fw-semibold">Jenis</th>
                                    <th class="text-primary text-uppercase small fw-semibold text-center">Qty</th>
                                    <th class="text-primary text-uppercase small fw-semibold text-end">Harga Satuan</th>
                                    <th class="text-primary text-uppercase small fw-semibold text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->itemPenjualan as $index => $item)
                                <tr>
                                    <td class="text-danger fw-semibold">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $item->produk->nama }}</td>
                                    <td class="text-muted">{{ $item->produk->jenis->nama ?? '-' }}</td>
                                    <td class="text-center">{{ $item->kuantitas }}</td>
                                    <td class="text-end">Rp {{ number_format($item->produk->harga_jual) }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($item->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-semibold pt-3">Total Tagihan</td>
                                    <td class="text-end fw-bold pt-3">Rp {{ number_format($sale->total_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end text-muted">Tunai Diterima</td>
                                    <td class="text-end">Rp {{ number_format($sale->cash_amount ?? $sale->total_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end fw-semibold text-success">Kembalian</td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($sale->kembalian ?? 0) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('penjualan.struk', $sale->id) }}" target="_blank" class="btn btn-primary px-4">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection