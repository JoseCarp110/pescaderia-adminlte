@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Detalles del Pedido</h2>

    <form action="{{ route('pedidos.confirmar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre_receptor">Nombre de quien recibirá el pedido:</label>
            <input type="text" name="nombre_receptor" id="nombre_receptor" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" name="provincia" id="provincia" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="forma_pago">Forma de Pago:</label>
            <select name="forma_pago" id="forma_pago" class="form-control" required>
                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                <option value="transferencia">Transferencia Bancaria</option>
                <option value="efectivo">Efectivo Contra Entrega</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Confirmar Compra</button>
        </div>
    </form>
</div>
@endsection
