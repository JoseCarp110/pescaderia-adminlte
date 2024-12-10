@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Tu Carrito</h2>

    <div id="mensajeExito" class="alert alert-success" style="display: none;"></div> <!-- Mensaje de éxito -->

    @if(empty($carrito))
        <div class="alert alert-info text-center">
            <h4>Tu carrito está vacío.</h4>
            <a href="{{ route('productos.index') }}" class="btn btn-primary mt-3">Ver Productos</a>
        </div>
    @else
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="carrito-table">
                @foreach($carrito as $id => $producto)
                    <tr id="producto-{{ $id }}" data-producto-id="{{ $id }}">
                        <td class="d-flex align-items-center">
                            <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}" class="img-thumbnail mr-2" style="width: 50px; height: 50px;">
                            {{ $producto['nombre'] }}
                        </td>
                        <td>${{ $producto['precio'] }}</td>
                        <td>
                            <input 
                                type="number" 
                                name="cantidad" 
                                class="form-control cantidad-input text-center" 
                                value="{{ $producto['cantidad'] }}" 
                                min="1" 
                                data-precio="{{ $producto['precio'] }}" 
                                style="width: 80px; margin: 0 auto;">
                        </td>
                        <td class="subtotal">${{ $producto['precio'] * $producto['cantidad'] }}</td>
                        <td>
                            <button onclick="eliminarDelCarrito({{ $id }})" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('productos.index') }}" class="btn btn-primary">Seguir Comprando</a>
            <h4>Total: <span id="total">${{ array_sum(array_map(function($p) { return $p['precio'] * $p['cantidad']; }, $carrito)) }}</span></h4>
            <a href="{{ route('pedidos.detalles') }}" class="btn btn-success">Proceder al Pago</a>
            
        </div>
    @endif
</div>

<style>
    /* Centrar el input en la celda */
    .cantidad-input {
        text-align: center;
    }

    /* Ocultar flechas de inputs tipo number */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
    }
</style>

<script>
    // Manejar la actualización de la cantidad
    document.querySelectorAll('.cantidad-input').forEach(input => {
        input.addEventListener('input', function() {
            // Validar solo números
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        input.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                const fila = this.closest('tr');
                const precio = parseFloat(this.dataset.precio);
                const cantidad = parseInt(this.value) || 1; // Asegurar un mínimo de 1
                const subtotal = precio * cantidad;

                // Actualizar subtotal
                fila.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

                // Recalcular total
                let total = 0;
                document.querySelectorAll('.cantidad-input').forEach(input => {
                    const precio = parseFloat(input.dataset.precio);
                    const cantidad = parseInt(input.value) || 1;
                    total += precio * cantidad;
                });
                document.getElementById('total').textContent = `$${total.toFixed(2)}`;
            }
        });
    });

    function eliminarDelCarrito(productoId) {
        fetch(`/carrito/eliminar/${productoId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Elimina el producto de la lista en la vista
            document.getElementById(`producto-${productoId}`).remove();

            // Actualiza el contador del carrito en la interfaz
            document.querySelector('.badge-danger').textContent = data.count;

            // Actualiza el total del carrito
            const total = data.total;
            document.getElementById('total').textContent = `$${total}`;

            // Muestra el mensaje de éxito
            mostrarMensajeExito(data.success);
        })
        .catch(error => console.error('Error:', error));
    }

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



