<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('testing.home') }}">
        <strong>Pescadería</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser" aria-controls="navbarUser" aria-expanded="false" aria-label="Menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarUser">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('testing.productos.indexuser') }}">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pedidos.historial') }}">Mis Compras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('usuarios.edit', auth()->user()->id) }}">Mi Cuenta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('carrito.index') }}">
              <i class="fas fa-shopping-cart"></i>
              Carrito 
              <span id="contador-carrito" class="badge bg-danger">{{ session('carrito') ? count(session('carrito')) : 0 }}</span>
          </a>
        </li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-link nav-link" type="submit">Cerrar sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
