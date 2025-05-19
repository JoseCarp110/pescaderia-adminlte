<nav class="main-header navbar navbar-expand navbar-dark bg-gradient-primary">
    <!-- Botón del sidebar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Menú derecho -->
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('carrito.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="carrito-contador" class="badge badge-danger navbar-badge">
                        {{ session('carrito') ? count(session('carrito')) : 0 }}
                    </span>
                </a>
            </li>
            <!-- Usuario -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img src="{{ Auth::user()->profile_picture_url }}" class="img-circle elevation-2" width="30" height="30" alt="User Image">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('testing.usuarios.edit', Auth::user()->id) }}" class="dropdown-item">Editar Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </li>
        @endguest
    </ul>
</nav>

