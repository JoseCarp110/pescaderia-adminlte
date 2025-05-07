<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('testing.partials.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    

    @include('testing.partials.sidebar')

   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Izquierda -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Derecha -->
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
                        <span id="carrito-contador" class="badge badge-danger navbar-badge">{{ session('carrito') ? count(session('carrito')) : 0 }}</span>
                    </a>
                </li>
                <!-- Perfil -->
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Pescaderia') }}</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Inicio</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Gestión de Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ml-3">
                                    <li class="nav-item">
                                        <a href="{{ route('testing.usuarios.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listar Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('testing.usuarios.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Agregar Usuario</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-fish"></i>
                                    <p>
                                        Gestión de Productos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ml-3">
                                    <li class="nav-item">
                                        <a href="{{ route('productos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listar Productos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('productos.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Agregar Producto</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pedidos.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>Gestión de Pedidos</p>
                                </a>
                            </li>
                        @elseif(Auth::user()->role == 'user')
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Inicio</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pedidos.historial') }}" class="nav-link">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>Ver Compras</p>
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Contenido -->
    <div class="content-wrapper p-4">
        @yield('content')
    </div>

    @include('testing.partials.footer')

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @auth
            fetch('{{ route('carrito.contador') }}')
                .then(res => res.json())
                .then(data => {
                    document.querySelector('#carrito-contador').textContent = data.count;
                });
        @endauth
    });
</script>

</body>
</html>
