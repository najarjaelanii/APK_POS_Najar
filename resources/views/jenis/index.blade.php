@extends('layouts.app')

@section('title', 'Jenis')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --shop-blue: #2e6de0;
        --shop-blue-dark: #1e52b8;
        --shop-blue-light: #eaf1fd;
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

    .sales-table-wrap {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #eee;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .sales-table thead th {
        background-color: var(--shop-blue-light);
        color: #1e3a6e;
        font-weight: 600;
        border-bottom: none;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .sales-table tbody tr {
        transition: background-color .15s ease;
    }
    .sales-table tbody tr:hover {
        background-color: #f7faff;
    }

    .sales-table td, .sales-table th {
        vertical-align: middle;
        padding: 12px 14px;
    }

    .action-btns {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .action-btns .btn {
        font-size: .78rem;
        padding: 4px 12px;
        border-radius: 4px;
    }

    .empty-state {
        text-align: center;
        padding: 50px 0;
        color: #999;
    }
</style>

<div class="container my-4">

    <div class="shopee-header">
        <h1> Daftar Jenis Produk</h1>
        <a href="{{ route('jenis.create') }}" class="btn btn-shopee">Create</a>
    </div>

    <div class="sales-table-wrap">
        <div class="table-responsive">
            <table class="table sales-table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Jenis</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenis as $index => $item)
                        <tr>
                            <td>{{ $jenis->firstItem() + $index }}</td>
                            <td>{{ $item->nama_jenis }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('jenis.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jenis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div style="font-size: 3rem;"></div>
                                    <p>Data jenis belum ada.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $jenis->links() }}
    </div>
</div>
@endsection