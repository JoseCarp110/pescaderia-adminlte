@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('{{ asset("images/carruselpescaderia5.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .register-panel {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
</style>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-7 register-panel">
        <div class="text-center mb-4">
            <i class="fas fa-user-plus fa-3x text-primary"></i>
            <h3 class="mt-2 text-primary">Registro de Usuario</h3>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input id="name" type="text" placeholder="Nombre Completo"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <input id="email" type="email" placeholder="Correo Electrónico"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <input id="password" type="password" placeholder="Contraseña"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required>
                @error('password')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <input id="password-confirm" type="password" placeholder="Confirmar Contraseña"
                    class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </div>
        </form>
    </div>
</div>
@endsection


