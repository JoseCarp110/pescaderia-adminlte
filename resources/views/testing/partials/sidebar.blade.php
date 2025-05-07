<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Pescadería') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Usuario (opcional) -->
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->profile_picture_url }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        @endauth

        <!-- Menú lateral -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ url('/test-adminlte') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio (Prueba)</p>
                    </a>
                </li>
                <!-- Agregá aquí más enlaces de prueba si querés -->
            </ul>
        </nav>
    </div>
</aside>
