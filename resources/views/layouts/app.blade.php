<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pescaderia') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">{{ config('app.name', 'Pescaderia') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menú de la izquierda -->
            <ul class="navbar-nav">
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <!-- Menú desplegable para Gestión de Usuarios -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestión de Usuarios
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                            <a class="dropdown-item" href="{{ route('usuarios.index') }}">Listar Usuarios</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('usuarios.create') }}">Agregar Usuarios</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestión de Productos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <a class="dropdown-item" href="{{ route('productos.index') }}">Listar Producto</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('productos.create') }}">Agregar Producto</a>
                        </div>   
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pedidos.index') }}">Gestión de Pedidos</a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pedidos.historial') }}">Ver Compras</a>
                    </li>
                @endif
            </ul>
            
            <!-- Menú de la derecha -->
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
                    </li>
                @else
                    <!-- Ícono del carrito con contador -->
                    <li class="nav-item">
                       <a class="nav-link" href="{{ route('carrito.index') }}">
                         <i class="fas fa-shopping-cart"></i>
                          <!-- Ahora cuenta los productos correctamente -->
                         <span id="carrito-contador" class="badge badge-pill badge-danger">{{ session()->has('carrito') ? count(session('carrito')) : 0 }}</span>

                        </a>
                    </li>

                    <!-- Menú desplegable para el usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'https://via.placeholder.com/30' }}" alt="Foto de perfil" class="rounded-circle" width="30" height="30" style="margin-right: 8px;">
                            {{ Auth::user()->role == 'admin' ? 'Admin' : 'Comun' }} {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('usuarios.edit', Auth::user()->id) }}">Editar Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                        </div>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Pie de Página -->
    <footer class="bg-light text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="text-uppercase">Ubicación</h5>
                    <p>Dirección de tu negocio.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase">Contacto</h5>
                    <p>Teléfono: +123456789</p>
                    <p>Email: contacto@acuarioburbujas.com</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase">Quiénes somos</h5>
                    <p>Información sobre tu empresa.</p>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark text-white">
            © 2024 Acuario Burbujas
        </div>
    </footer>

    <script>
        function actualizarContadorCarrito() {
           const contadorElemento = document.querySelector('#carrito-contador');

             if (!contadorElemento) {
               console.error('No se encontró el elemento del contador del carrito.');
             return;
             }

             fetch('{{ route('carrito.contador') }}')
             .then(response => response.json())
             .then(data => {
                // Actualiza el contador solo si la respuesta es válida
             if (data && typeof data.count === 'number') {
                contadorElemento.textContent = data.count;
             }
            })
             .catch(error => console.error('Error al obtener el contador del carrito:', error));
        }

    
          document.addEventListener('DOMContentLoaded', function () {
            // Llama a la función solo si el usuario está autenticado
          @auth
            actualizarContadorCarrito();
          @endauth
         });
    
        // Opcional: puedes llamar a esta función cada vez que se agregue o elimine un producto.
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>





