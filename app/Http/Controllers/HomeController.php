<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Oferta;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*  public function __construct()
    {
        $this->middleware('auth');
    }
 */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtén los productos desde la base de datos
        $productos = Producto::all();
        
        // Obtén las ofertas especiales (por ejemplo, las 4 primeras ofertas)
        $ofertasEspeciales = Oferta::take(4)->get();

        // Inicializa la variable $otrosProductos (puedes cambiar la lógica si es necesario)
        $otrosProductos = []; 

        // Pasa las variables a la vista
        return view('home', [
            'productos' => $productos, 
            'otrosProductos' => $otrosProductos,
            'ofertasEspeciales' => $ofertasEspeciales
        ]);
    }

    public function mostrarProductos()
    {
        // Lógica similar a la del método index()
        $productos = Producto::all();
        $ofertasEspeciales = Oferta::take(4)->get();
        $otrosProductos = [];

        return view('home', [
            'productos' => $productos, 
            'otrosProductos' => $otrosProductos,
            'ofertasEspeciales' => $ofertasEspeciales
        ]);
    }

}
