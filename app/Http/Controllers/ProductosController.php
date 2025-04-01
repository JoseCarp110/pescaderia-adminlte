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
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer|min:0',
            //'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'es_oferta' => 'nullable|boolean', // Validación para el campo es_oferta
            'precio_oferta' => 'nullable|numeric|lt:precio', // Validación para el campo precio_oferta, menor que precio
            'categoria_id' => 'required|exists:categorias,id' // Validacion para el campo de categorias
        ]);
        
        if (!$request->hasFile('imagen')) {
            return back()->with('error', 'No se detectó ninguna imagen en la solicitud');
        }

        // Validar la imagen
        $request->validate([
        'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subir la imagen
        $imageName = time().'.'.$request->imagen->extension();  
        $request->imagen->move(public_path('images'), $imageName);
    
            // Guardar el producto en la base de datos
            Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'cantidad' => $request->cantidad,
                'imagen_url' => '/images/' . $imageName,
                'es_oferta' => $request->has('es_oferta') ? true : false, // Guarda si es una oferta o no
                'precio_oferta' => $request->precio_oferta, // Guarda el precio de oferta si está presente
                'categoria_id' => $request->categoria_id,
            ]);
    
        // Redirigir a la página de productos o mostrar un mensaje de éxito
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
    // Obtener el producto de la base de datos
    $producto = Producto::findOrFail($id);

    // Validar los datos del formulario
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

    // Actualizar los datos del producto (excepto la imagen)
    $producto->update($request->except('imagen'));

    // Procesar la imagen si se sube una nueva
    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('images', $fileName, 'public');

        // Eliminar imagen anterior si existe
        if ($producto->imagen_url) {
            Storage::disk('public')->delete($producto->imagen_url);
        }

        // Guardar la nueva imagen en la BD
        $producto->imagen_url = $filePath;
    }

    // Guardar cambios finales en la BD
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