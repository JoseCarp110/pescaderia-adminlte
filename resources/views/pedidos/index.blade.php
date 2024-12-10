@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-4">Gestión de Pedidos</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($mensaje))
        <!-- Mensaje cuando no hay pedidos -->
        <div class="alert alert-info">
            <h4>{{ $mensaje }}</h4>
            <p>Actualmente no hay ningún pedido registrado en el sistema.</p>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
        </div>
    @else
        <!-- Tabla de pedidos -->
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    @foreach($pedido->productos as $producto) <!-- Iteramos los productos del pedido -->
                        <tr>
                            <!-- Columna Producto: Mostrar solo la imagen sin descripción -->
                            <td>
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" 
                                     class="img-thumbnail" style="width: 50px; height: 50px;">
                            </td>

                            <!-- Columna Cliente -->
                            <td>{{ $pedido->user->name }}</td>

                            <!-- Columna Cantidad -->
                            <td>{{ $producto->pivot->cantidad }}</td> <!-- Cantidad solicitada -->

                            <!-- Columna Total -->
                            <td>${{ $pedido->total }}</td>

                            <!-- Columna Estado: Combobox con los estados -->
                            <td>
                                <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-control">
                                        <option value="pendiente" {{ $pedido->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="enviado" {{ $pedido->status == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                        <option value="entregado" {{ $pedido->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection


