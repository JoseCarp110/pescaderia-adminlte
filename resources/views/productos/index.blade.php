@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Buscador y Filtros -->
    <form action="{{ route('productos.index') }}" method="GET" class="mb-4 d-flex justify-content-center">
        <input type="text" name="search" class="form-control me-2" placeholder="Buscar productos..." value="{{ old('search', $search ?? '') }}" style="max-width: 400px;">
        
        <select name="filter" class="form-control me-2" style="max-width: 200px;">
            <option value="">Filtrar por</option>
            <option value="ventas_desc">Más vendidos</option>
            <option value="precio_asc">Precios más bajos</option>
            <option value="precio_desc">Precios más caros</option>
            <option value="categoria_articulos_pesca">Artículos de Pesca</option>
            <option value="categoria_alimentos">Alimentos</option>
            <!-- Aquí puedes añadir más categorías según las disponibles -->
        </select>

        <button class="btn btn-primary" type="submit">Buscar</button>
    </form>

    <!-- Panel de productos con scroll infinito -->
    <div id="productos-container" class="row gy-4 justify-content-center" style="height: 600px; overflow-y: auto;">
        @foreach($productos as $producto)
        <div class="col-lg-3 col-md-4 col-sm-6 producto-item" data-producto-id="{{ $producto->id }}">
            <div class="card border-0 position-relative producto-card">
                <div class="producto-img-container">
                    <img src="{{ $producto->imagen_url }}"  class="img-fluid producto-img" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="producto-info position-absolute w-100 h-100 d-flex align-items-center justify-content-center flex-column">
                    <h5 class="text-white text-center fw-bold">{{ $producto->nombre }}</h5>

                    <div class="mt-2">
                        @if(Auth::check() && Auth::user()->role == 'admin')
                            <!-- Botones solo para administradores -->
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                            </form>
                        @else
                            <!-- Botón de "Añadir al carrito" solo para usuarios comunes -->
                            <a href="#" class="btn btn-primary btn-sm">Añadir al carrito</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
// Aplicar efectos de agrandado y mostrar información del producto al pasar el ratón
function agregarEventosHover() {
    document.querySelectorAll('.producto-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            const img = card.querySelector('.producto-img');
            const info = card.querySelector('.producto-info');
            img.style.transform = 'scale(1.1)';
            info.style.opacity = 1;
        });

        card.addEventListener('mouseleave', () => {
            const img = card.querySelector('.producto-img');
            const info = card.querySelector('.producto-info');
            img.style.transform = 'scale(1)';
            info.style.opacity = 0;
        });
    });
}

// Llamar a la función al cargar la página para que funcione el hover
agregarEventosHover();

// Scroll infinito para cargar más productos
let productosContainer = document.getElementById('productos-container');
productosContainer.addEventListener('scroll', function() {
    if (productosContainer.scrollTop + productosContainer.clientHeight >= productosContainer.scrollHeight) {
        cargarMasProductos();
    }
});

let paginaActual = 1;

function cargarMasProductos() {
    paginaActual++;
    fetch(`{{ route('productos.index') }}?page=${paginaActual}`)
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                productosContainer.insertAdjacentHTML('beforeend', data.html);
                agregarEventosHover(); // Vuelve a agregar eventos a los nuevos productos cargados
            }
        });
}
</script>

<style>
#productos-container {
    scrollbar-width: thin;
}

.producto-card {
    overflow: hidden;
}

.producto-img-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.producto-img {
    transition: transform 0.3s ease;
}

.producto-info {
    opacity: 0;
    background: rgba(0, 0, 0, 0.6);
    transition: opacity 0.3s ease;
}
</style>
@endsection












