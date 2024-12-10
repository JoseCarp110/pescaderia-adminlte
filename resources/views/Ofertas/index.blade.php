@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Todos los Productos en Oferta</h1>
    
    <!-- Buscador -->
    <form action="" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar ofertas...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Lista de Ofertas -->
    <div class="row mt-3">
        @foreach($ofertas as $oferta)
            <div class="col-md-3 mb-4">
                <div class="card h-100 bg-warning text-white">
                    <img class="card-img-top img-fluid" src="{{ $oferta->imagen_url }}" alt="{{ $oferta->nombre }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $oferta->nombre }}</h5>
                        <p class="card-text">{{ $oferta->descripcion }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ $oferta->precio }}</p>
                        <a href="#" class="btn btn-dark">Comprar ahora</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
