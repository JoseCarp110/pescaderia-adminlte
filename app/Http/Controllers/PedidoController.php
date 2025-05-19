<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;

class PedidoController extends Controller
{
    public function index()
    {
    if (auth()->user()->role === 'admin') {
        // Incluir pedidos sin productos también
        $pedidos = Pedido::with('user', 'productos')->get();
    } else {
        $pedidos = Pedido::with('productos')
                    ->where('user_id', auth()->id())
                    ->get();
    }

    if ($pedidos->isEmpty()) {
        return view('pedidos.index')->with('mensaje', 'No hay pedidos cargados.');
    }

    return view('pedidos.index', compact('pedidos'));
    }

    public function updateStatus(Request $request, $id)
    {
    if (auth()->user()->role !== 'admin') {
        abort(403, 'No tienes permiso para realizar esta acción.');
    }

    $pedido = Pedido::findOrFail($id);
    $pedido->status = $request->status;
    $pedido->save();

    return redirect()->route('pedidos.index')->with('success', 'Estado del pedido actualizado.');
    }


    public function checkout()
    {
    $carrito = session()->get('carrito');

    // Validar que el carrito no esté vacío
    if (empty($carrito)) {
        return redirect()->route('productos.index')->with('error', 'Tu carrito está vacío.');
    }

    // Validar que los productos tengan las claves necesarias
    foreach ($carrito as $producto) {
        if (!isset($producto['precio'], $producto['cantidad'])) {
            return redirect()->route('productos.index')->with('error', 'Hay un problema con los datos del carrito.');
        }
    }

    $pedido = new Pedido();
    $pedido->user_id = auth()->id(); // Validar que el usuario esté autenticado
    $pedido->total = array_sum(array_map(function ($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $carrito)); // Calcular el total correctamente
    $pedido->save();

    foreach ($carrito as $id => $producto) {
        $pedido->productos()->attach($id, [
            'cantidad' => $producto['cantidad'],
            'precio' => $producto['precio'],  
        ]);
    }
    
    session()->forget('carrito');

    return redirect()->route('pedidos.index')->with('success', 'Pedido realizado con éxito.');
    }

    public function miHistorial()
    {
    // Obtener los pedidos del usuario autenticado comun
    $pedidos = auth()->user()->pedidos()->latest()->get();

    if ($pedidos->isEmpty()) {
        $mensaje = 'No tienes pedidos registrados.';
        return view('pedidos.historial', compact('mensaje'));
    }

    return view('pedidos.historial', compact('pedidos'));
    }

    public function detallesPedido()
    {
    // Recuperar el carrito desde la sesión
    $carrito = session()->get('carrito');

    if (empty($carrito)) {
        return redirect()->route('productos.index')->with('error', 'Tu carrito está vacío.');
    }

    return view('pedidos.detalles', compact('carrito'));
    }

    // Antes de realizar la compra (Detalles del usuario y la compra)
    public function confirmarPedido(Request $request)
    {
    $validated = $request->validate([
        'nombre_receptor' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'provincia' => 'required|string|max:100',
        'codigo_postal' => 'required|string|max:10',
        'forma_pago' => 'required|string|max:50',
    ]);

    // Obtener el carrito de la sesión
    $carrito = session()->get('carrito');

    // Verificar si el carrito está vacío
    if (empty($carrito)) {
        return redirect()->route('productos.index')->with('error', 'Tu carrito está vacío.');
    }
    
    // Crear el pedido y asociarlo al usuario
    $pedido = new Pedido([
        'user_id' => auth()->id(),
        'total' => array_sum(array_map(function ($producto) {
            return $producto['precio'] * $producto['cantidad'];
        }, session()->get('carrito'))),
        'status' => 'pendiente',
        'direccion' => $validated['direccion'],
        'provincia' => $validated['provincia'],
        'codigo_postal' => $validated['codigo_postal'],
        'forma_pago' => $validated['forma_pago'],
        'nombre_receptor' => $validated['nombre_receptor'],
    ]);
    
    $pedido->save();
    
     // Asociar los productos del carrito al pedido en la tabla pivot 'pedido_producto'
     foreach ($carrito as $id => $producto) {
        $pedido->productos()->attach($id, [
            'cantidad' => $producto['cantidad'],
            'precio' => $producto['precio'],
        ]);
    }

    // Limpiar el carrito
    session()->forget('carrito');

    return redirect()->route('productos.index')->with('success', 'Pedido confirmado con éxito.');
    }

    // Metodo que permite mostrar los detalles del pedido comprado por el cliente.
    public function verPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $producto = $pedido->productos->first(); // Ajusta según tu lógica para obtener el producto asociado

        return view('pedidos.verPedido', compact('pedido', 'producto'));
    }


    //METODOS DE TESTING **********************************************

    public function indexTesting()
    {
    if (auth()->user()->role !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }

    $pedidos = Pedido::with('user', 'productos')->get();

    return view('testing.pedidos.index', compact('pedidos'));
    }

    

}
