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




//METODOS DE TESTING **********************************************

 // METODO QUE LISTA TODOS LOS PRODUCTOS
public function indexTesting(Request $request)
{
    $query = Producto::query();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->search . '%')
              ->orWhere('descripcion', 'like', '%' . $request->search . '%')
              ->orWhereHas('categoria', function ($subq) use ($request) {
                  $subq->where('nombre', 'like', '%' . $request->search . '%');
              });
        });
    }
    if ($request->has('filter')) {
        switch ($request->filter) {
            case 'ventas_desc':
                $query->orderBy('ventas', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'categoria_articulos_pesca':
                $query->where('categoria', 'artículos de pesca');
                break;
            case 'categoria_alimentos':
                $query->where('categoria', 'alimentos');
                break;
        }
    }
    $productos = $query->paginate(12);

    if ($request->ajax()) {
        $html = view('testing.productos.partials.productos', compact('productos'))->render();
        return response()->json(['html' => $html]);
    }
    return view('testing.productos.index', compact('productos'));
}


// METODO PARA CREAR PRODUCTOS
public function createTesting()
{
    $categorias = Categoria::all();
    return view('testing.productos.create', compact('categorias'));
}


// METODO QUE ALMACENAN LOS PRODUCTOS EN LA BASE DE DATOS
public function storeTesting(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric|min:1',
        'cantidad' => 'required|integer|min:1',
        'imagen' => 'required|image|max:2048', 
        'categoria_id' => 'required|exists:categorias,id',
        'precio_oferta' => $request->has('es_oferta') ? 'required|numeric|min:0.01' : 'nullable|numeric|min:0.01',
    ]);

    $producto = new Producto($request->except('imagen', 'es_oferta', 'precio_oferta'));
    $producto->es_oferta = $request->has('es_oferta');
    $producto->precio_oferta = $request->input('precio_oferta');

    if ($request->hasFile('imagen')) {
        $producto->imagen_url = $request->file('imagen')->store('productos', 'public');
    }
    $producto->save();
    return redirect()->route('testing.productos.index')->with('success', 'Producto creado exitosamente.');
}


// METODO DE EDICION DE PRODUCTOS
public function editTesting($id)
{
    $producto = Producto::findOrFail($id);
    $categorias = Categoria::all();

    return view('testing.productos.edit', compact('producto', 'categorias'));
}

// METODO QUE ACTUALIZA PRODUCTOS
public function updateTesting(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric|min:1',
        'cantidad' => 'required|integer|min:1',
        'imagen' => 'nullable|image|max:2048',
        'categoria_id' => 'required|exists:categorias,id',
        'precio_oferta' => $request->has('es_oferta') ? 'required|numeric|min:0.01' : 'nullable|numeric|min:0.01',
    ]);

    $producto = Producto::findOrFail($id);
    $producto->fill($request->except('imagen', 'es_oferta', 'precio_oferta'));

    // Checkbox no enviado si no está marcado, así que se maneja manualmente
    $producto->es_oferta = $request->has('es_oferta');
    $producto->precio_oferta = $request->input('precio_oferta');

    if ($request->hasFile('imagen')) {
        // Opcional: eliminar imagen anterior si existe
        if ($producto->imagen && \Storage::disk('public')->exists($producto->imagen)) {
            \Storage::disk('public')->delete($producto->imagen);
        }
        $producto->imagen = $request->file('imagen')->store('productos', 'public');
    }
    $producto->save();

    return redirect()->route('testing.productos.index')->with('success', 'Producto actualizado correctamente.');
}


// METODO QUE ELIMINA EL PRODUCTO
public function destroyTesting($id)
{
    $producto = Producto::findOrFail($id);

    if ($producto->imagen && \Storage::disk('public')->exists($producto->imagen)) {
        \Storage::disk('public')->delete($producto->imagen);
    }

    $producto->delete();

    return redirect()->route('testing.productos.index')->with('success', 'Producto eliminado correctamente.');
}


}