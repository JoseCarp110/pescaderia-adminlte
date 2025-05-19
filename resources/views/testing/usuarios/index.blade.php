@extends('testing.layouts.adminlte')

@section('title', 'Lista de Usuarios')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="card-title mb-2 mb-md-0">Usuarios</h3>
        <div class="ml-auto d-flex align-items-center">
            {{-- Formulario de búsqueda opcional --}}
            <form action="{{ route('testing.usuarios.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar usuarios..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('testing.usuarios.create') }}" class="btn btn-primary btn-sm ml-2">
                <i class="fas fa-plus"></i> Agregar Usuario
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <table class="table table-hover text-nowrap">
            <thead>
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
                @forelse($usuarios as $usuario)
                <tr>
                    <td>
                        <img src="{{ $usuario->profile_picture_url }}" alt="Foto de perfil" class="img-thumbnail rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->role }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('testing.usuarios.edit', $usuario->id) }}" class="btn btn-primary btn-sm px-3 py-2 mx-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('testing.usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-3 py-2 mx-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

