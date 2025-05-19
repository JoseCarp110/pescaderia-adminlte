@extends('testing.layouts.adminlte')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Añadir Usuario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('testing.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Imagen de perfil -->
                            <div class="col-md-4 d-flex flex-column align-items-center">
                                <img id="imagen_previa" src="https://placehold.co/300x300?text=Sin+Imagen&font=roboto"
                                    class="img-thumbnail mb-3" style="width: 100%; max-width: 300px; height: auto;">
                                <div class="form-group w-100">
                                    <label for="profile_picture" class="text-center w-100">Imagen de Perfil</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control-file">
                                </div>
                            </div>

                            <!-- Campos del formulario -->
                            <div class="col-md-8">
                                <!-- Nombre -->
                                <div class="form-group mb-3">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
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
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="password_confirmation">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control" id="password_confirmation" required>
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
                               
                                <!-- Botones alineados con los campos -->
                                <div class="form-group mt-4">
                                   <div class="row">
                                     <div class="col-md-6 mb-2">
                                      <button type="submit" class="btn btn-primary w-100">Guardar Usuario</button>
                                     </div>
                                     <div class="col-md-6 mb-2">
                                      <a href="{{ route('testing.usuarios.index') }}" class="btn btn-danger w-100">Cancelar</a>
                                     </div>
                                  </div>
                               </div>
                            </div>
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
