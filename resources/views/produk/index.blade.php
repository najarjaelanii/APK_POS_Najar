@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<h1>Halaman Produk</h1>

{{-- PERBAIKAN 1: Typo ::classs diperbaiki jadi ::class --}}
@can('create', App\Models\Produk::class)
  <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">create</a>
{{-- PERBAIKAN 2: Penutupan @endcan ditambahkan di sini --}}
@endcan

<form action="{{ route('produk.index') }}" method="GET" class="mb-3">
  <div class="input-group">
    <input
      type="text"
      name="search"
      value="{{ request('search') }}"
      class="form-control"
      placeholder="Search nama produk"
    >
    <button class="btn btn-outline-secondary" type="submit">
      Search
    </button>
  </div>
</form>

<table class="table align-middle">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User</th>
      <th scope="col">Foto</th>
      <th scope="col">Nama</th>
      <th scope="col">Harga Beli</th>
      <th scope="col">Harga Jual</th>
      <th scope="col">Stok</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($products as $product)
    <tr>
      <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
      
      {{-- Kolom User --}}
      <td>{{ $product->user->name ?? '-' }}</td>
      
      {{-- Kolom Foto --}}
      <td>
        @if ($product->foto)
          <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" width="70" height="70" class="img-thumbnail style-object-fit">
        @else
          <span class="text-muted">-</span>
        @endif
      </td>
      
      {{-- Kolom Detail Produk --}}
      <td>{{ $product->nama }}</td>
      <td>{{ $product->harga_beli }}</td>
      <td>{{ $product->harga_jual }}</td>
      <td>{{ $product->stok }}</td>
      
      <td>
        @can('update', $product)
          <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">Edit</a>
        {{-- PERBAIKAN 3: Ditambahkan @endcan untuk update --}}
        @endcan

        @can('delete', $product)
          <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
              Hapus
            </button>
          </form>
        @endcan
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="8" class="text-center">Data tidak tersedia.</td>
    </tr>
    @endforelse
  </tbody>
</table>

{{ $products->links() }}

@endsection