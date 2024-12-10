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
                    <th>ID</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>${{ $pedido->total }}</td>
                        <td>{{ ucfirst($pedido->status) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
