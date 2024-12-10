@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Agregar Nueva Categoría</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulario para añadir una nueva categoría -->
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        
        <!-- Nombre de la Categoría -->
        <div class="form-group">
            <label for="nombre">Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" id="nombre" required>
        </div>

        <!-- Descripción de la Categoría -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" rows="3"></textarea>
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Agregar Categoría</button>
        <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
    </form>
</div>
@endsection
