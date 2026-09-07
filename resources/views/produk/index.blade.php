@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --shop-blue: #2e6de0;
        --shop-blue-dark: #1e52b8;
        --shop-bg: #f5f5f5;
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

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 4px;
        overflow: hidden;
        transition: box-shadow .2s ease, transform .2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .product-img-wrap {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: var(--shop-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-img-wrap .no-image {
        color: #bbb;
        font-size: .85rem;
    }

    .stock-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        font-size: .7rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 3px;
        color: #fff;
    }
    .stock-badge.ok { background-color: #2e6de0; }
    .stock-badge.low { background-color: #f9a825; }
    .stock-badge.empty { background-color: #999; }

    .product-body {
        padding: 10px 12px 12px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-size: .9rem;
        color: #333;
        line-height: 1.3;
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 6px;
    }

    .product-price {
        color: var(--shop-blue);
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 8px;
    }

    .product-meta {
        font-size: .75rem;
        color: #888;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .product-actions {
        display: flex;
        gap: 6px;
        margin-top: auto;
    }
    .product-actions .btn {
        flex: 1;
        font-size: .78rem;
        padding: 4px 6px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 0;
        color: #999;
    }
</style>

<div class="container my-4">

    <div class="shopee-header">
        <h1> Halaman Produk</h1>

        @can('create', App\Models\Produk::class)
            <a href="{{ route('produk.create') }}" class="btn btn-shopee">Create</a>
        @endcan
    </div>

    <form action="{{ route('produk.index') }}" method="GET">
        <div class="input-group shopee-search">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Cari nama produk..."
            >
            <button class="btn btn-search" type="submit">
                 Cari
            </button>
        </div>
    </form>

    @forelse ($products as $product)
    @if ($loop->first)
        <div class="product-grid">
    @endif

        <div class="product-card">
            <div class="product-img-wrap">
                @if ($product->foto)
                    <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}">
                @else
                    <span class="no-image">Tidak ada foto</span>
                @endif

                @if ($product->stok == 0)
                    <span class="stock-badge empty">Stok Habis</span>
                @elseif ($product->stok <= 5)
                    <span class="stock-badge low">Stok Menipis</span>
                @else
                    <span class="stock-badge ok">Tersedia</span>
                @endif
            </div>

            <div class="product-body">
                <div class="product-name">{{ $product->nama }}</div>

                <div class="product-price">Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</div>

                <div class="product-meta">
                    <span> {{ $product->user->name ?? '-' }}</span>
                    <span> Stok: {{ $product->stok }}</span>
                </div>

                <div class="product-actions">
                    @can('update', $product)
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    @endcan

                    @can('delete', $product)
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline flex-fill">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100" onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                Hapus
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

    @if ($loop->last)
        </div>
    @endif
    @empty
        <div class="empty-state">
            <div style="font-size: 3rem;"></div>
            <p>Data produk tidak tersedia.</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>

@endsection