@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Miniaturas -->
        <div class="col-md-1">
            <div class="row mb-2">
                <img src="https://via.placeholder.com/300" alt="Imagen por defecto" class="img-fluid">
            </div>
            <div class="row mb-2">
                <img src="https://via.placeholder.com/300" alt="Imagen por defecto" class="img-fluid">
            </div>
            <div class="row mb-2">
                <img src="https://via.placeholder.com/300" alt="Imagen por defecto" class="img-fluid">
            </div>
        </div>

        <!-- Imagen principal con carrusel -->
        <div class="col-md-5">
            <div id="productoCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-fluid">
                    </div>
                    <!-- Imágenes adicionales por defecto -->
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300" alt="Imagen por defecto 1" class="img-fluid">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300" alt="Imagen por defecto 2" class="img-fluid">
                    </div>
                </div>
                <!-- Controles del carrusel -->
                <a class="carousel-control-prev" href="#productoCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#productoCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-6">
            <h2>{{ $producto->nombre }}</h2>
            @if($producto->es_oferta)
                <h4 class="text-danger">${{ $producto->precio_oferta }}</h4>
                <del>${{ $producto->precio }}</del>
            @else
                <h4>${{ $producto->precio }}</h4>
            @endif
            <p>{{ $producto->descripcion }}</p>

            <!-- Controles de cantidad -->
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <div class="input-group" style="width: 150px;">
                    <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                    <input type="number" id="cantidad" value="1" min="1" class="form-control text-center">
                    <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                </div>
                <!-- Cantidad disponible en negrita y entre paréntesis -->
                <span><strong>({{ $producto->cantidad_disponible }} disponibles)</strong></span>
            </div>

            <!-- Botón para agregar al carrito sin formulario -->
            <button onclick="agregarAlCarrito({{ $producto->id }})" class="btn btn-primary">
                Agregar al Carrito
            </button>
            <div id="mensajeExito" class="alert alert-success" style="display: none;"></div>

            <!-- Campo de código postal y botón calcular -->
            <div class="form-group mt-4">
                <label for="codigoPostal">Código postal:</label>
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" class="form-control" id="codigoPostal" placeholder="Tu código postal">
                    <button class="btn btn-outline-primary" type="button">Calcular</button>
                </div>
            </div>

            <!-- Información adicional de envíos -->
            <p class="mt-3"><i class="fas fa-truck"></i> Medios de envío</p>
            <p class="text-muted"><i class="fas fa-store"></i> Nuestro local</p>
            <p>Visítanos para conocer más productos y promociones exclusivas.</p>
        </div>
    </div>
</div>

<script>
    // Funciones para ajustar cantidad
    document.getElementById('decrease').addEventListener('click', function () {
        var cantidad = document.getElementById('cantidad');
        if (cantidad.value > 1) {
            cantidad.value--;
        }
    });

    document.getElementById('increase').addEventListener('click', function () {
        var cantidad = document.getElementById('cantidad');
        cantidad.value++;
    });

    // Función para agregar al carrito usando AJAX
    function agregarAlCarrito(productoId) {
        fetch(`/carrito/agregar/${productoId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ cantidad: document.getElementById('cantidad').value })
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.badge-danger').textContent = data.count;
            mostrarMensajeExito(data.success);
        })
        .catch(error => console.error('Error:', error));
    }

    // Función para mostrar mensaje de éxito de que se añadio el producto al carrito
    function mostrarMensajeExito(mensaje) {
        const mensajeExito = document.getElementById('mensajeExito');
        mensajeExito.style.display = 'block';
        mensajeExito.textContent = mensaje;

        setTimeout(() => {
            mensajeExito.style.display = 'none';
        }, 3000);
    }
</script>
@endsection



