<!-- resources/views/testing/layouts/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-2">
    <a href="{{ route('testing.home') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">Panel Admin</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu">

                <li class="nav-item">
                    <a href="{{ route('testing.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <!-- Usuarios -->
                <li class="nav-item">
                    <a href="{{ route('testing.usuarios.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <!-- Productos -->
                <li class="nav-item">
                    <a href="{{ route('testing.productos.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>Productos</p>
                    </a>
                </li>

                <!-- Pedidos -->
                <li class="nav-item">
                    <a href="{{ route('testing.pedidos.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Pedidos</p>
                    </a>
                </li>

                <!-- Reportes -->
                <li class="nav-item">
                    <a href="{{ route('testing.reportes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Reportes</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
