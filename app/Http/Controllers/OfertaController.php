<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;

class OfertaController extends Controller
{

// Muestra todas las ofertas de productos
public function index()
{
    // Obtener todas las ofertas desde la base de datos
    $ofertas = Oferta::all();
    return view('ofertas.index', compact('ofertas'));
}

   
// Muestra las ofertas destacadas en el home (por ejemplo, las 4 primeras)
public function showHome()
{
    // Obtener solo un número limitado de ofertas (ej. las 4 primeras)
    $ofertasEspeciales = Oferta::take(4)->get();
    return view('home', compact('ofertasEspeciales'));
}


// Se cargan las ofertas de productos
public function store(Request $request)
{
    $validatedData = $request->validate([
        'nombre' => 'required',
        'descripcion' => 'nullable',
        'precio' => 'required|numeric',
        'imagen_url' => 'nullable|url',
    ]);

    Oferta::create($validatedData);
    return redirect()->back()->with('success', 'Oferta creada exitosamente');
}

}
