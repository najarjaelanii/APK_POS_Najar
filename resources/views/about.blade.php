@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

@include('layouts.navbar')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- ================== HEADER TOKO ================== --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light border"
                         style="width:110px; height:110px;">
                        <i class="bi bi-shop fs-1 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Najar Fashion</h3>
                    <p class="text-primary fw-semibold mb-0">Fashion Store • Pakaian & Celana Berkualitas</p>
                </div>
            </div>

            {{-- ================== TENTANG TOKO ================== --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle-fill text-primary"></i> Tentang Najar Fashion
                    </h6>
                    <p class="text-muted mb-0">
                        <strong>Najar Fashion</strong> adalah toko pakaian yang menyediakan berbagai produk fashion
                        untuk kebutuhan sehari-hari, mulai dari <strong>baju, kaos, celana, hingga aksesoris outdoor</strong>.
                        Kami berkomitmen menghadirkan produk berkualitas dengan harga terjangkau, cocok untuk
                        segala aktivitas — kasual, outdoor, maupun gaya sehari-hari. Sistem kasir digital ini
                        digunakan untuk mendukung operasional toko agar transaksi lebih cepat, rapi, dan tercatat
                        dengan baik.
                    </p>
                </div>
            </div>

            {{-- ================== DETAIL TOKO & TEKNOLOGI ================== --}}
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-shop-window text-primary"></i> Informasi Toko
                            </h6>
                            <p class="mb-2"><strong>Nama Toko:</strong> Najar Fashion</p>
                            <p class="mb-2"><strong>Kategori:</strong> Pakaian & Fashion</p>
                            <p class="mb-2"><strong>Produk:</strong> Baju, Kaos, Celana, Sepatu, Aksesoris</p>
                            <p class="mb-0"><strong>Sistem:</strong> Kasir Digital (POS)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-cpu text-primary"></i> Teknologi & Tools
                            </h6>
                            <p class="mb-2"><i class="bi bi-code-slash"></i> <strong>Framework:</strong> Laravel 12 & PHP 8.4</p>
                            <p class="mb-2"><i class="bi bi-palette"></i> <strong>UI:</strong> Bootstrap & Icons</p>
                            <p class="mb-2"><i class="bi bi-hdd-network"></i> <strong>Server:</strong> Apache</p>
                            <p class="mb-0"><i class="bi bi-database"></i> <strong>Database:</strong> MySQL</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================== TUJUAN APLIKASI ================== --}}
            <div class="card border-0 rounded-3" style="background-color:#eaf1fd;">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-primary mb-2">
                        <i class="bi bi-bullseye"></i> Tujuan Aplikasi
                    </h6>
                    <p class="text-muted mb-0">
                        Aplikasi kasir ini dibuat untuk membantu <strong>Najar Fashion</strong> dalam mencatat
                        transaksi penjualan, mengelola stok produk, serta memantau laporan penjualan harian
                        secara lebih cepat, rapi, dan akurat — sehingga operasional toko menjadi lebih efisien.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection