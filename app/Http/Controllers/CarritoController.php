<?php

namespace App\Http\Controllers;
use App\Models\Producto;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }



    public function agregar(Request $request, $productoId)
    {
    $producto = Producto::findOrFail($productoId);
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$productoId])) {
        $carrito[$productoId]['cantidad']++;
    } else {
        $carrito[$productoId] = [
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => 1,
            'imagen_url' => $producto->imagen_url,
        ];
    }
    session()->put('carrito', $carrito);
    // Responder con el nuevo conteo de productos en el carrito
    return response()->json(['count' => count($carrito), 'success' => 'Producto agregado al carrito.']);
    }   



    public function actualizar(Request $request, $productoId)
    {
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$productoId])) {
        $carrito[$productoId]['cantidad'] = $request->input('cantidad');
        session()->put('carrito', $carrito);
    }
    return response()->json(['count' => count($carrito), 'success' => 'Cantidad actualizada.']);
    }



    public function eliminar($productoId)
    {
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$productoId])) {
        unset($carrito[$productoId]);
        session()->put('carrito', $carrito);
    }

    $total = array_sum(array_map(function($p) { return $p['precio'] * $p['cantidad']; }, $carrito));

    return response()->json(['count' => count($carrito), 'success' => 'Producto eliminado del carrito.', 'total' => $total]);
    }

}
