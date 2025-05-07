@extends('testing.layouts.adminlte')

@section('content')
<section class="content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <form action="{{ route('testing.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data" class="row w-100">
            @csrf
            @method('PUT')

            <!-- Imagen -->
            <div class="col-md-4 d-flex flex-column align-items-center mt-4">
                <img id="profile-picture-preview" 
                     src="{{ $usuario->profile_picture_url }}" 
                     alt="Foto de perfil actual" 
                     class="img-fluid img-thumbnail mb-3" 
                     style="max-width: 300px;">  
                <div class="form-group w-100 px-3">
                    <label for="profile_picture">Cambiar Imagen de Perfil</label>
                    <input type="file" name="profile_picture" class="form-control-file" id="profile_picture">
                </div>            
            </div>

            <!-- Datos -->
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Usuario</h3>
                    </div>
                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success"> 
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="current_password">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="new_password">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        @if(Auth::user()->role == 'admin' && Auth::user()->id != $usuario->id)
                        <div class="form-group">
                            <label for="role">Rol</label>
                            <select name="role" class="form-control" required>
                                <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        <a href="{{ route('testing.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</section>

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
