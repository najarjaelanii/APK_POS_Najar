@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')
<div class="container my-4">
    <h2>Tambah Jenis Produk</h2>

    <form action="{{ route('jenis.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Nama Jenis</label>
            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" value="{{ old('nama_jenis') }}" required>
            @error('nama_jenis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection