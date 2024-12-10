@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row w-100">
        <!-- Imagen para el nuevo usuario -->
        <div class="col-md-4 d-flex flex-column align-items-center" style="margin-top: 120px;"> <!-- Ajuste para bajar la imagen -->
            <!-- Mostrar imagen seleccionada o marcador de posición -->
            <img id="imagen_previa" src="https://via.placeholder.com/300" alt="Foto de perfil" class="img-thumbnail mb-3" style="width: 100%; max-width: 300px; height: auto;">
            
            <!-- Seleccionar Imagen de Perfil -->
            <div class="form-group mt-3">
                <input type="file" name="profile_picture" class="form-control-file" id="profile_picture" onchange="mostrarImagenPrevia(event)">
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

                <!-- Contraseña y Confirmar Contraseña en la misma fila -->
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

                <!-- Botón de Enviar -->
                <button type="submit" class="btn btn-primary mt-4">Añadir Usuario</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-4">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script>
    function mostrarImagenPrevia(event) {
        const imagenPrevia = document.getElementById('imagen_previa');
        imagenPrevia.src = URL.createObjectURL(event.target.files[0]);
        imagenPrevia.onload = function() {
            URL.revokeObjectURL(imagenPrevia.src);
        };
    }
</script>

@endsection

