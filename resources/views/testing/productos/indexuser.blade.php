@extends('testing.layouts.userlte')

@section('title', 'Listado de Productos')

@section('content')
<div class="container-fluid">
    <!-- Buscador y Filtros -->
    <form action="{{ route('productos.index') }}" method="GET" class="mb-4 row justify-content-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Buscar productos..." value="{{ old('search', $search ?? '') }}">
        </div>
        <div class="col-md-3">
            <select name="filter" class="form-control">
                <option value="">Filtrar por</option>
                <option value="ventas_desc">Más vendidos</option>
                <option value="precio_asc">Precios más bajos</option>
                <option value="precio_desc">Precios más caros</option>
                <option value="categoria_articulos_pesca">Artículos de Pesca</option>
                <option value="categoria_alimentos">Alimentos</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Productos -->
    <div id="productos-container" class="row gy-4 justify-content-center" style="height: 600px; overflow-y: auto;">
        @foreach($productos as $producto)
            <div class="col-lg-3 col-md-4 col-sm-6 producto-item" data-producto-id="{{ $producto->id }}">
                <div class="card producto-card border-0 shadow-sm">
                    <div class="producto-img-container">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="producto-img">
                        <div class="producto-overlay">
                            <h5 class="text-white fw-bold text-center mb-2">{{ $producto->nombre }}</h5>
                            @auth
                                @if(Auth::user()->role == 'admin')
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<style>
#productos-container {
    scrollbar-width: thin;
    padding-right: 10px;
}

.producto-img-container {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    border-radius: 0.5rem;
}

.producto-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    display: block;
}

.producto-card:hover .producto-img {
    transform: scale(1.1);
}

.producto-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0.5rem;
    text-align: center;
}

.producto-card:hover .producto-overlay {
    opacity: 1;
}

.producto-overlay .btn {
    margin: 0.2rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let container = document.getElementById('productos-container');
    let paginaActual = 1;

    container.addEventListener('scroll', function () {
        if (container.scrollTop + container.clientHeight >= container.scrollHeight - 10) {
            cargarMasProductos();
        }
    });

    function cargarMasProductos() {
        paginaActual++;
        fetch(`{{ route('productos.index') }}?page=${paginaActual}`)
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    document.getElementById('productos-container').insertAdjacentHTML('beforeend', data.html);
                }
            });
    }
});
</script>
@endsection
