@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h3 class="fw-bold text-dark mb-0">Edit Produk</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('produk._form')
        </form>
    </div>

</div>

@endsection