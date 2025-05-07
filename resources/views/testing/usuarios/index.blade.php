@extends('testing.layouts.adminlte')

@section('title', 'Lista de Usuarios')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>
                        <img src="{{ $usuario->profile_picture_url }}" alt="Foto de perfil" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->role }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('testing.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('testing.usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
