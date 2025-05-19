<aside class="main-sidebar sidebar-dark-info elevation-4 d-flex flex-column">
    <!-- Logo -->
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-light">Acuario Burbujas</span>
    </a>

    <!-- Contenedor principal del sidebar -->
    <div class="flex-grow-1 d-flex flex-column justify-content-between">
        
        <!-- Menú principal -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('testing.home') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Inicio</p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link text-white">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Gestión de Usuarios<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview ml-3">
                                <li class="nav-item">
                                    <a href="{{ route('testing.usuarios.index') }}" class="nav-link text-white">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listar Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('testing.usuarios.create') }}" class="nav-link text-white">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Agregar Usuario</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link text-white">
                                <i class="nav-icon fas fa-fish"></i>
                                <p>Gestión de Productos<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview ml-3">
                                <li class="nav-item">
                                    <a href="{{ route('testing.productos.index') }}" class="nav-link text-white">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listar Productos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('testing.productos.create') }}" class="nav-link text-white">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Agregar Producto</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('testing.pedidos.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Gestión de Pedidos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('testing.reportes.index') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    @elseif(Auth::user()->role === 'user')
                        <li class="nav-item">
                            <a href="{{ route('testing.home') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Inicio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pedidos.historial') }}" class="nav-link text-white">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Ver Compras</p>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>

        <!-- Pie con botón de cerrar sesión -->
        @auth
        <div class="sidebar-footer p-3">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" class="nav-link text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </a>
            </form>
        </div>
        @endauth
    </div>
</aside>

<!-- Estilos para mejorar apariencia -->
<style>
    .main-sidebar .nav-link {
        background-color: rgba(255, 255, 255, 0.05);
        color: white !important;
        border-radius: 0.25rem;
        margin-bottom: 2px;
    }

    .main-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    .main-sidebar .nav-treeview .nav-link {
        padding-left: 2.5rem;
    }

    .sidebar-footer .nav-link {
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>


