@extends('layouts.app')

@section('title', 'Users')

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

    .badge-role {
        font-size: .72rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        text-transform: capitalize;
    }
    .badge-role.admin {
        background-color: #eaf1fd;
        color: var(--shop-blue-dark);
    }
    .badge-role.kasir {
        background-color: #fdf0e0;
        color: #a5670a;
    }
    .badge-role.default {
        background-color: #eee;
        color: #666;
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
        <h1> Halaman Users</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-shopee">Create</a>
    </div>

    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="input-group shopee-search">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Cari username atau email..."
            >
            <button class="btn btn-search" type="submit">
                 Cari
            </button>
        </div>
    </form>

    <div class="sales-table-wrap">
        <div class="table-responsive">
            <table class="table sales-table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php $roleName = $user->role->name ?? null; @endphp
                                @if ($roleName === 'admin')
                                    <span class="badge-role admin">{{ $roleName }}</span>
                                @elseif ($roleName === 'kasir')
                                    <span class="badge-role kasir">{{ $roleName }}</span>
                                @else
                                    <span class="badge-role default">{{ $roleName ?? '-' }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin hapus user ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div style="font-size: 3rem;"></div>
                                    <p>Data user tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $users->links() }}
    </div>
</div>

@endsection