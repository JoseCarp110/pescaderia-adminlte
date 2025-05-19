@extends('testing.layouts.adminlte')

@section('title', 'Listado de Productos')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
       <h3 class="card-title mb-2 mb-md-0">Productos</h3>
       <div class="ml-auto d-flex align-items-center">
        <form action="{{ route('testing.productos.index') }}" method="GET" class="form-inline mr-2">
            <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                  </div>
            </div>
        </form>
        <a href="{{ route('testing.productos.create') }}" class="btn btn-primary btn-sm ml-2"><i class="fas fa-plus"></i> Agregar Producto</a>
     </div>
  </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>
                       <!-- Muestra el precio TACHADO si es que hay una oferta --> 
                       @if($producto->es_oferta && $producto->precio_oferta < $producto->precio)
                         <span class="text-muted" style="text-decoration: line-through;">${{ number_format($producto->precio, 2) }}</span><br>
                         <span class="text-danger font-weight-bold">${{ number_format($producto->precio_oferta, 2) }}</span>
                       @else
                         <span>${{ number_format($producto->precio, 2) }}</span>
                       @endif
                    </td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>
                       <img src="{{ $producto->imagen_url }}" class="rounded shadow-sm" style="object-fit: cover;" width="70" height="70">
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('testing.productos.edit', $producto->id) }}" class="btn btn-primary btn-sm px-3 py-2 mx-1">
                             <i class="fas fa-edit"></i>
                          </a>
                          <form action="{{ route('testing.productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminarlo?')">
                            @csrf
                            @method('DELETE')
                           <button class="btn btn-danger btn-sm px-3 py-2 mx-1"> <i class="fas fa-trash"></i> </button>
                          </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($productos->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No hay productos cargados.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection





