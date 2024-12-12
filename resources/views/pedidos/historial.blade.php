@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Mis Compras</h2>

    @if(isset($mensaje))
        <div class="alert alert-info">
            <h4>{{ $mensaje }}</h4>
            <p>Puedes explorar productos y realizar compras.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Explorar Productos</a>
    @else
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    @foreach($pedido->productos as $producto)
                        <tr>
                            <td>
                            <a href="{{ route('pedidos.verPedido', $pedido->id) }}">
                              <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-thumbnail efecto-zoom" style="width: 80px; height: auto;">
                            </a>
                            </td>
                            <td>${{ $pedido->total }}</td>
                            <td>{{ ucfirst($pedido->status) }}</td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<style>
    .efecto-zoom {
        transition: transform 0.3s ease;
    }
    .efecto-zoom:hover {
        transform: scale(1.5);
    }
</style>
@endsection


