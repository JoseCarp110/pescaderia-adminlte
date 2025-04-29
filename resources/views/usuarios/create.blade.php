@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row w-100">
        <!-- Imagen para el nuevo usuario + input -->
        <div class="col-md-4 d-flex flex-column align-items-center" style="margin-top: 120px;">
            <!-- Imagen previa -->
            <img id="imagen_previa" 
                 src="https://placehold.co/300x300?text=Sin+Imagen&font=roboto" 
                 alt="Foto de perfil" 
                 class="img-thumbnail mb-3" 
                 style="width: 100%; max-width: 300px; height: auto;">
            
            <!-- Input de imagen -->
            <div class="form-group w-100 px-3">
                <label for="profile_picture" class="text-center w-100">Seleccionar Imagen de Perfil</label>
                <input type="file" name="profile_picture" class="form-control-file" id="profile_picture">
            </div>
        </div>

        <!-- Formulario para añadir usuario -->
        <div class="col-md-8">
            <h1 class="text-center my-4">Añadir Usuario</h1>

            <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nombre del Usuario -->
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contraseña y Confirmación -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                    </div>
                </div>

                <!-- Rol -->
                <div class="form-group">
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
                <button type="submit" class="btn btn-primary mt-4">Añadir Usuario</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-4">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagen_previa').setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection


