@extends('layouts.app')

@section('title', 'POS')

@section('content')

<style>
    h4 {
        color: #2c3e50;
    }

    .table thead th {
        background-color: #4e73df !important;
        color: #ffffff !important;
    }

    .btn-primary,
    .btn-outline-primary:hover {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-outline-primary {
        color: #4e73df;
        border-color: #4e73df;
    }

    .btn-success {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-success:hover {
        background-color: #3d5fc4;
        border-color: #3d5fc4;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    #kembalian-box {
        background-color: #f4f6fd;
        border: 1px solid #d9e0f7;
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 600;
    }

    #kembalian-box.kurang {
        background-color: #fdeeee;
        border-color: #f3c6c6;
        color: #c0392b;
    }

    #qris-box {
        background-color: #f4f6fd;
        border: 1px solid #d9e0f7;
        border-radius: 8px;
        padding: 12px;
    }
</style>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<h4 class="mb-3">Tambah dan Edit</h4>

<div class="row">

    {{-- -------------------- PRODUK -------------------- --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="max-height:70vh; overflow:auto">

                <form method="GET" action="{{ route('penjualan.create') }}">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control mb-3"
                        placeholder="Cari produk..."
                        oninput="clearTimeout(window._st); window._st = setTimeout(() => this.form.submit(), 500)">
                </form>

                @foreach($products as $product)
                <form method="POST" action="{{ route('itempenjualan.store') }}" class="row mb-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">

                    <div class="col-7">
                        <button type="button" class="btn btn-outline-primary w-100 text-start p-2"
                            {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('storage/'.$product->foto) }}"
                                    alt="Gambar"
                                    class="rounded-circle"
                                    style="width:45px; height:45px; object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $product->nama }}</div>
                                    <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-3">
                        <input type="number" name="quantity" value="1" min="1"
                            class="form-control {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary w-100
                            {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">+</button>
                    </div>
                </form>
                @endforeach

            </div>
        </div>
    </div>{{-- END col-md-6 PRODUK --}}

    {{-- ==================== KERANJANG ==================== --}}
    <div class="col-md-6">
        <div class="card">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sale->itempenjualan as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>Rp {{ number_format($item->produk->harga_jual) }}</td>
                        <td>
                            <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                @csrf @method('PUT')
                                <input type="number" name="quantity"
                                    value="{{ $item->kuantitas }}"
                                    min="1"
                                    class="form-control form-control-sm"
                                    {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}
                                    onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->subtotal) }}</td>
                        <td>
                            @if($sale->status !== 'COMPLETED')
                                @can('delete', $item)
                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endcan
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Keranjang masih kosong
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="card-footer">
                <div class="mb-2">
                    <strong>Total: Rp {{ number_format($sale->total_pembayaran) }}</strong>
                </div>

                {{-- Form Checkout --}}
                <form method="POST" action="{{ route('penjualan.update', $sale->id) }}"
                    id="checkout-form"
                    onsubmit="return confirm('Yakin ingin checkout?')" class="mt-2">
                    @csrf @method('PUT')

                    <input type="hidden" name="total_pembayaran" value="{{ $sale->total_pembayaran }}">

                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select mb-2"
                        {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                        <option value="">Pilih Pembayaran</option>
                        <option value="CASH" {{ $sale->metode_pembayaran === 'CASH' ? 'selected' : '' }}>Cash</option>
                        <option value="QRIS" {{ $sale->metode_pembayaran === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>

                    <div id="uang-dibayar-wrapper" class="mb-2 d-none">
                        <label class="form-label mb-1">Uang Dibayar</label>
                        <input type="number" name="uang_dibayar" id="uang_dibayar"
                            class="form-control"
                            min="0"
                            step="500"
                            placeholder="Masukkan jumlah uang diterima"
                            value="{{ old('uang_dibayar', $sale->uang_dibayar) }}"
                            {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>

                        <div id="kembalian-box" class="mt-2">
                            Kembalian: Rp <span id="kembalian-value">0</span>
                        </div>
                    </div>

                    {{-- QR Code QRIS (statis) --}}
                    <div id="qris-box" class="mb-2 d-none text-center">
                        <img src="{{ asset('images/qris.png') }}" alt="QRIS" style="width:220px; height:auto;">
                        <p class="mb-0 mt-1 text-muted">Scan QR di atas untuk membayar</p>
                    </div>

                    <button type="submit" id="checkout-btn"
                        class="btn btn-success w-100"
                        {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                        Checkout
                    </button>
                </form>

                {{-- Form Batal Transaksi - hanya admin --}}
                @if($sale->status !== 'COMPLETED')
                    @can('delete', $sale)
                    <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}" class="mt-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100"
                            onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                            Batal Transaksi
                        </button>
                    </form>
                    @endcan
                @endif
            </div>
        </div>
    </div>

</div>

<script>
    (function () {
        const total = {{ (int) $sale->total_pembayaran }};
        const metodeSelect = document.getElementById('metode_pembayaran');
        const wrapper = document.getElementById('uang-dibayar-wrapper');
        const uangInput = document.getElementById('uang_dibayar');
        const kembalianBox = document.getElementById('kembalian-box');
        const kembalianValue = document.getElementById('kembalian-value');
        const qrisBox = document.getElementById('qris-box');
        const checkoutBtn = document.getElementById('checkout-btn');
        const sudahCompleted = {{ $sale->status === 'COMPLETED' ? 'true' : 'false' }};

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function toggleUangDibayar() {
            if (metodeSelect.value === 'CASH') {
                wrapper.classList.remove('d-none');
                uangInput.setAttribute('required', 'required');
                qrisBox.classList.add('d-none');
            } else if (metodeSelect.value === 'QRIS') {
                wrapper.classList.add('d-none');
                uangInput.removeAttribute('required');
                qrisBox.classList.remove('d-none');
            } else {
                wrapper.classList.add('d-none');
                uangInput.removeAttribute('required');
                qrisBox.classList.add('d-none');
            }
            hitungKembalian();
        }

        function hitungKembalian() {
            if (sudahCompleted) return;

            if (metodeSelect.value !== 'CASH') {
                checkoutBtn.disabled = false;
                return;
            }

            const dibayar = parseInt(uangInput.value || 0, 10);
            const kembalian = dibayar - total;

            if (dibayar <= 0) {
                kembalianValue.textContent = '0';
                kembalianBox.classList.remove('kurang');
                checkoutBtn.disabled = true;
                return;
            }

            if (kembalian < 0) {
                kembalianValue.textContent = formatRupiah(Math.abs(kembalian)) + ' (kurang)';
                kembalianBox.classList.add('kurang');
                checkoutBtn.disabled = true;
            } else {
                kembalianValue.textContent = formatRupiah(kembalian);
                kembalianBox.classList.remove('kurang');
                checkoutBtn.disabled = false;
            }
        }

        metodeSelect.addEventListener('change', toggleUangDibayar);
        uangInput.addEventListener('input', hitungKembalian);

        // set kondisi awal saat halaman dimuat (mis. setelah reload/validasi gagal)
        toggleUangDibayar();
    })();
</script>

@endsection