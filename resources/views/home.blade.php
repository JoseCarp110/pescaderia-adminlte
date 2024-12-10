@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Carrusel de Imágenes -->
    <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Primera promoción">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h5 class="display-4 text-light">¡Descuentos del 20%!</h5>
                    <p class="text-light">Hasta fin de mes</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    
    <!-- Productos -->
    <h2 class="text-center my-5">Productos Destacados</h2>
    <div class="productos-container" style="max-height: 600px; overflow-y: auto;">
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="img-container" style="position: relative;">
                            <img class="card-img-top" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="object-fit: cover; height: 220px; border-radius: 10px;">
                            @if($producto->es_oferta)
                            <span class="badge badge-danger position-absolute" style="top: 10px; left: 10px;">Oferta</span>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="font-weight-bold mb-2">{{ $producto->nombre }}</h5>
                            <p class="text-muted">{{ $producto->descripcion }}</p>
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                @if($producto->es_oferta && $producto->precio_oferta)
                                    <h5 class="text-danger mr-2">${{ $producto->precio_oferta }}</h5>
                                    <small class="text-muted"><del>${{ $producto->precio }}</del></small>
                                @else
                                    <h5 class="text-primary">${{ $producto->precio }}</h5>
                                @endif
                            </div>
                            
                            <!-- Mostrar el botón solo para usuarios comunes -->
                            @if(auth()->check() && auth()->user()->role != 'admin')
                            <a href="{{ route('producto.detalle', $producto->id) }}" class="btn btn-outline-primary btn-block">Comprar ahora</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Panel transparente con botón de "Ver más productos" -->
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="background-color: rgba(0, 0, 0, 0.05);">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver más productos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formas de Pago -->
    <h2 class="text-center my-5">Formas de Pago</h2>
    <div class="d-flex justify-content-center">
        <img src="images/logos/visa-logo.png" alt="Visa" class="mx-3" style="max-height: 50px;">
        <img src="images/logos/mastercard-logo.png" alt="Mastercard" class="mx-3" style="max-height: 50px;">
        <img src="images/logos/paypal-logo.png" alt="PayPal" class="mx-3" style="max-height: 50px;">
    </div>
</div>
@endsection

