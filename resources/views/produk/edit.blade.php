@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<h4>Edit Produk</h4>

<form action="{{ route('produk.update', $produk->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    {{-- PERBAIKAN: Mengubah Produk._form menjadi produk._form (huruf kecil) --}}
    @include('produk._form')
</form>
@endsection