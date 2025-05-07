@extends('layouts.app')

@section('content')
<style>
    body {
    position: relative;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    overflow-x: hidden;
}

body::before {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset("images/carruselpescaderia5.jpg") }}') no-repeat center center;
    background-size: cover;
    filter: blur(6px);
    z-index: -1;
}
    
    .login-panel {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
</style>

<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 login-panel">
        <div class="text-center mb-4">
            <i class="fas fa-user-circle fa-3x text-primary"></i>
            <h3 class="mt-2 text-primary">Iniciar Sesión</h3>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input id="email" type="email" placeholder="Correo Electrónico"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus>
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

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Recordar Usuario
                </label>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-2">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

