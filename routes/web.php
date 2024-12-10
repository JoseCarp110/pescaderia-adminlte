<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CarritoController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta pública para la página de inicio (ACCESIBLE PARA TODOS)
Route::get('/', [HomeController::class, 'mostrarProductos'])->name('home');
Route::get('/ofertas', [ProductosController::class, 'mostrarOfertas'])->name('productos.ofertas'); // Ruta para ver los productos en oferta

// Autenticación de Laravel
Auth::routes();

// Ruta protegida para usuarios autenticados (USUARIOS COMUNES)
Route::middleware(['auth'])->group(function () {
    // Ruta para que usuarios logueados accedan al home público
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Ruta para que usuarios logueados accedan a la lista de productos
    //Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index'); // Ruta para ver productos y ofertas solo por los usuarios logueados.


    // Ruta para que usuarios comunes editen sus propios datos
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update'); // Actualiza los usuarios editados

    // Rutas para el carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar/{producto}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar/{producto}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('pedidos.checkout');
    Route::get('/producto/{id}', [ProductosController::class, 'mostrarDetalle'])->name('producto.detalle');
    

    
    //Ruta para que usuarios comunes visualicen sus compras y formas de pago
    Route::get('/mis-compras', [PedidoController::class, 'miHistorial'])->name('pedidos.historial');
    Route::get('/pedidos/detalles', [PedidoController::class, 'detallesPedido'])->name('pedidos.detalles');
    Route::post('/pedidos/confirmar', [PedidoController::class, 'confirmarPedido'])->name('pedidos.confirmar');


    //Ruta que se utiliza para actualizar el numero de productos en el carrito en tiempo real.
    Route::get('/carrito/contador', function () {
        $carrito = session()->get('carrito', []);
        return response()->json(['count' => count($carrito)]);
    })->name('carrito.contador');
});


// RUTAS PROTEGIDAS PARA LOS ADMINISTRADORES ****************************************************************************************************
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rutas para Gestión de PRODUCTOS
    Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create'); // Vista para crear productos
    Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store'); // Almacena los productos creados
    Route::get('/productos/{id}/edit', [ProductosController::class, 'edit'])->name('productos.edit'); // Selecciona el producto que se va a editar
    Route::put('/productos/{id}', [ProductosController::class, 'update'])->name('productos.update'); // Actualiza los datos editados en la BD
    Route::delete('/productos/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy'); // Eliminar producto

    // Rutas para Gestión de USUARIOS (Solo accesibles para administradores) ************************************************************************
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index'); // Lista los usuarios existentes en la base
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create'); // Crear nuevo usuario
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store'); // Almacenar nuevo usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy'); // Eliminar usuarios
    
    // Rutas para Categorias
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias/store', [CategoriaController::class, 'store'])->name('categorias.store');

    // Rutas para Ofertas
    Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store'); // almacenar productos en ofertas

    // Rutas para Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::put('/pedidos/{id}/status', [PedidoController::class, 'updateStatus'])->name('pedidos.updateStatus');


});
