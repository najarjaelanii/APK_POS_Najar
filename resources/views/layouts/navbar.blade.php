<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a href="/dashboard" style="color: inherit; text-decoration: none;">najar fashion</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ Route::has('dashboard') ? route('dashboard') : '/dashboard' }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="/admin/users">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('jenis*') ? 'active' : '' }}" href="{{ Route::has('jenis.index') ? route('jenis.index') : '/jenis' }}">Jenis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ Route::has('produk.index') ? route('produk.index') : '/produk' }}">Produk</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ Route::has('penjualan.index') ? route('penjualan.index') : '/penjualan' }}">Penjualan</a>
        </li> 
      </ul>
      
      <form action="{{ Route::has('logout') ? route('logout') : '/logout' }}" method="POST" class="d-flex">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </div>
</nav>