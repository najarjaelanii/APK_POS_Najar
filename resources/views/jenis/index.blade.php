@extends('layouts.app')

@section('title', 'Jenis')

@section('content')

    @include('layouts.navbar')

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Jenis Produk</h2>
            <a href="{{ route('jenis.create') }}" class="btn btn-primary">Tambah Jenis</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Jenis</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenis as $index => $item)
                        <tr>
                            <td>{{ $jenis->firstItem() + $index }}</td>
                            <td>{{ $item->nama_jenis }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('jenis.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jenis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data Jenis belum ada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $jenis->links() }}
        </div>
    </div>
@endsection
