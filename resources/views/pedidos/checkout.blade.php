@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Checkout</h2>
    
    <div class="row">
        <!-- Resumen del pedido -->
        <div class="col-md-6">
            <h4>Resumen del Pedido</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrito as $id => $producto)
                        <tr>
                            <td>{{ $producto['nombre'] }}</td>
                            <td>{{ $producto['cantidad'] }}</td>
                            <td>${{ $producto['precio'] * $producto['cantidad'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                <h5>Total: ${{ array_sum(array_map(function($p) { return $p['precio'] * $p['cantidad']; }, $carrito)) }}</h5>
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="col-md-6">
            <h4>Datos de Envío</h4>
            <form action="{{ route('pedidos.checkout') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ auth()->user()->name }}" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección de Envío</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>

                <!-- Información de pago -->
                <h4>Detalles de Pago</h4>
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select class="form-control" id="metodo_pago" name="metodo_pago">
                        <option value="tarjeta">Tarjeta de Crédito</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-block">Finalizar Compra</button>
            </form>
        </div>
    </div>
</div>
@endsection
