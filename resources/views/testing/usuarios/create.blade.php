@extends('testing.layouts.adminlte')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">

        <!-- Imagen de perfil -->
        <div class="col-md-4 text-center">
            <img id="imagen_previa" 
                 src="https://placehold.co/300x300?text=Sin+Imagen&font=roboto" 
                 class="img-thumbnail mb-3 rounded-circle" 
                 style="width: 100%; max-width: 300px; height: auto;">
            
            <div class="form-group">
                <label for="profile_picture">Imagen de Perfil</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control-file">
            </div>
        </div>

        <!-- Formulario -->
        <div class="col-md-8">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Añadir Usuario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('testing.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nombre -->
                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña y Confirmación -->
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Rol -->
                        <div class="form-group mb-4">
                            <label for="role">Rol</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('testing.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview de imagen -->
<script>
    document.getElementById('profile_picture').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('imagen_previa').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
