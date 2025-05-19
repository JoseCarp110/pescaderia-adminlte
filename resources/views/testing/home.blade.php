@php
    $layout = auth()->user()->role === 'admin' ? 'testing.layouts.adminlte' : 'testing.layouts.userlte';
@endphp

@extends($layout)

@section('title', 'Inicio (Prueba)')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Bienvenido al entorno de pruebas</div>
            <div class="card-body">
                <p class="mb-0">
                    @if(auth()->user()->role === 'admin')
                        Este es el panel de administrador usando AdminLTE.
                    @else
                        Este es el panel de usuario común usando AdminLTE.
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
