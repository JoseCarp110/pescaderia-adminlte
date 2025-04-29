<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
    // Obtener todas las categorías desde la tabla de categorías
    $categorias = Categoria::all();
    // Pasar las categorías a la vista de creación de productos
    return view('productos.create', compact('categorias'));
    }


    
    /**
     * Guardar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric',
        'cantidad' => 'required|integer|min:0',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'es_oferta' => 'nullable|boolean',
        'precio_oferta' => 'nullable|numeric|lt:precio',
        'categoria_id' => 'required|exists:categorias,id'
    ]);

    $imagePath = null;
    if ($request->hasFile('imagen')) {
        $imagePath = $request->file('imagen')->store('productos', 'public');
    }

    Producto::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'cantidad' => $request->cantidad,
        'imagen_url' => $imagePath,
        'es_oferta' => $request->has('es_oferta'),
        'precio_oferta' => $request->precio_oferta,
        'categoria_id' => $request->categoria_id,
    ]);

    return redirect()->route('productos.index')->with('success', 'Producto agregado con éxito.');
    }
 
    
    /**
      * Mostrar la lista de productos.
     */
    public function index(Request $request)
    {
    $search = $request->input('search');  // Captura la búsqueda
    $esOferta = $request->has('ofertas'); // Revisa si está solicitando ofertas

    // Filtra productos, ya sea por búsqueda o por ofertas
    $query = Producto::query();

    if ($esOferta) {
        $query->where('es_oferta', true);
    }

    if ($search) {
        $query->where('nombre', 'LIKE', "%{$search}%")
              ->orWhere('descripcion', 'LIKE', "%{$search}%");
    }

    $productos = $query->get(); // Obtener los productos filtrados

    return view('productos.index', compact('productos', 'esOferta', 'search'));
    }



// Método para mostrar la vista de edición
public function edit($id)
{
    $producto = Producto::findOrFail($id);
    $categorias = Categoria::all();
    return view('productos.edit', compact('producto', 'categorias'));
}



// Método para actualizar el producto en la base de datos
public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'precio' => 'required|numeric',
        'es_oferta' => 'boolean',
        'precio_oferta' => 'nullable|numeric',
        'categoria_id' => 'required|exists:categorias,id',
        'cantidad' => 'required|integer|min:0',
    ]);

    if ($request->hasFile('imagen')) {
        $oldPath = public_path('storage/' . $producto->imagen_url);
        if ($producto->imagen_url && file_exists($oldPath)) {
            unlink($oldPath);
        }

        $imagePath = $request->file('imagen')->store('productos', 'public');
        $producto->imagen_url = $imagePath;
    }

    $producto->fill($request->except('imagen'));
    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
}



// Método para eliminar un producto
public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return redirect()->route('productos.index')->with('success', 'Prodcuto eliminado correctamente');
}

// Metodo que filtra cada una de las ofertas
public function mostrarOfertas()
{
    $productos = Producto::where('es_oferta', true)->get();
    return view('productos.index', ['productos' => $productos, 'esOferta' => true]);
}

// Metodo para mostrar detalle del producto antes de agregarlo al carrito.
public function mostrarDetalle($id)
{
    $producto = Producto::find($id);
    if (!$producto) {
        return redirect()->route('productos.index')->with('error', 'Producto no encontrado');
    }
    return view('productos.detalle', compact('producto'));
}

}