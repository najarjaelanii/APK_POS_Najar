@extends('layouts.app')

@section('title', 'Edit Jenis')

@section('content')
<div class="container my-4">
    <h2>Edit Jenis Produk</h2>

    <form action="{{ route('jenis.update', $jenis->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Nama Jenis</label>
            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" value="{{ old('nama_jenis', $jenis->nama_jenis) }}" required>
            @error('nama_jenis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection