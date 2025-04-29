@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data" class="row w-100">
        @csrf
        @method('PUT')

        <!-- Imagen actual del usuario + input -->
        <div class="col-md-4 d-flex flex-column align-items-center" style="margin-top: 120px;">
            <img id="profile-picture-preview" 
                 src="{{ $usuario->profile_picture_url }}" 
                 alt="Foto de perfil actual" 
                 class="img-thumbnail mb-3" 
                 style="width: 100%; max-width: 300px; height: auto;">  

            <!-- Input de imagen (ahora dentro del form) -->
            <div class="form-group w-100 px-3">
                <label for="profile_picture" class="text-center w-100">Cambiar Imagen de Perfil</label>
                <input type="file" name="profile_picture" class="form-control-file" id="profile_picture">
            </div>            
        </div>

        <!-- Datos del formulario -->
        <div class="col-md-8">
            <h1 class="text-center my-4">Editar Usuario</h1>

            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="alert alert-success"> 
                    {{ session('success') }}
                </div>
            @endif

            <!-- Nombre -->
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $usuario->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contraseñas -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="current_password">Contraseña Actual</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="current_password">
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="new_password">Nueva Contraseña</label>
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirmar nueva contraseña -->
            <div class="form-group">
                <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
            </div>

            <!-- Rol -->
            @if(Auth::user()->role == 'admin' && Auth::user()->id != $usuario->id)
            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            @endif

            <!-- Botones -->
            <button type="submit" class="btn btn-primary mt-4">Actualizar Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-4">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-picture-preview').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection



