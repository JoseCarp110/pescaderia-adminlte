<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
   {
    // Producto más vendido (puede ser null si no hay pedidos)
    $productoMasVendido = PedidoProducto::select('producto_id', DB::raw('SUM(cantidad) as total'))
        ->groupBy('producto_id')
        ->orderByDesc('total')
        ->with('producto')
        ->first();

    // Usuario que más compró
    $usuarioMasCompras = Pedido::select('user_id', DB::raw('COUNT(*) as total'))
        ->groupBy('user_id')
        ->orderByDesc('total')
        ->with('usuario')
        ->first();

    // Total de ventas (sumatoria)
    $totalVentas = Pedido::sum('total');

    // Pedidos pendientes
    $pedidosPendientes = Pedido::where('status', 'pendiente')->count();

    // Datos para gráficos
    $topProductos = PedidoProducto::select('producto_id', DB::raw('SUM(cantidad) as total'))
        ->groupBy('producto_id')
        ->orderByDesc('total')
        ->with('producto')
        ->take(5)
        ->get();

    $topUsuarios = Pedido::select('user_id', DB::raw('COUNT(*) as total'))
        ->groupBy('user_id')
        ->orderByDesc('total')
        ->with('usuario')
        ->take(5)
        ->get();

    return view('testing.reportes.index', compact(
        'productoMasVendido',
        'usuarioMasCompras',
        'totalVentas',
        'pedidosPendientes',
        'topProductos',
        'topUsuarios'
    ));
   }   
}
