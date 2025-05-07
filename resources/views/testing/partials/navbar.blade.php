<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botón para colapsar sidebar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Enlaces del lado derecho -->
    <ul class="navbar-nav ml-auto">
        @auth
        <li class="nav-item dropdown">
            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </li>
        @endauth
    </ul>
</nav>
