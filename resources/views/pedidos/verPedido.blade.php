@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Imagen principal del producto -->
        <div class="col-md-5">
            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-fluid mb-4">
        </div>

        <!-- Descripción y detalles del producto -->
        <div class="col-md-7">
            <h2>{{ $producto->nombre }}</h2>
            <h4 class="text-primary">${{ $producto->precio }}</h4>

            <p>{{ $producto->descripcion }}</p>

            <div class="row mt-4">
                <!-- Información del Pedido -->
                <div class="col-md-6">
                    <h5>Pedido</h5>
                    <p><strong>Total del Pedido:</strong> ${{ $pedido->total }}</p>
                    <p><strong>Estado del Pedido:</strong> {{ ucfirst($pedido->status) }}</p>
                    <p><strong>Fecha de Compra:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Información del Cliente -->
                <div class="col-md-6">
                    <h5>Cliente</h5>
                    <p><strong>Nombre:</strong> Juan Pérez</p>
                    <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad Ejemplo</p>
                    <p><strong>Forma de Pago:</strong> Tarjeta de Crédito</p>
                    <p><strong>Fecha Estimada de Entrega:</strong> 10/12/2024</p>
                </div>
            </div>

            <!-- Botón para volver a la lista de pedidos -->
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary mt-4">Volver a Mis Compras</a>
        </div>
    </div>
</div>
@endsection

