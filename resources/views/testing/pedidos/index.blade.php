@extends('testing.layouts.adminlte')

@section('title', 'Gestión de Pedidos')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(isset($mensaje))
        <x-adminlte-callout theme="info" title="Información">
            <h4>{{ $mensaje }}</h4>
            <p>Actualmente no hay ningún pedido registrado en el sistema.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
        </x-adminlte-callout>
    @else
        <div class="row">
            @php
                $hayProductos = $pedidos->filter(fn($p) => $p->productos->isNotEmpty())->isNotEmpty();
            @endphp

            @if(!$hayProductos)
                <div class="col-12">
                    <x-adminlte-callout theme="info" title="Sin productos">
                        Actualmente no hay productos asociados a ningún pedido.
                    </x-adminlte-callout>
                </div>
            @endif

            @foreach($pedidos as $pedido)
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-0">
                                Pedido de {{ $pedido->user->name }} - 
                                <small class="text-light">Total: ${{ number_format($pedido->total, 2) }}</small>
                            </h5>
                        </div>

                        <div class="card-body">
                            @if($pedido->productos->isEmpty())
                                <x-adminlte-callout theme="warning" title="Pedido vacío">
                                    Este pedido no contiene productos asociados.
                                </x-adminlte-callout>
                            @else
                                <ul class="list-group mb-3">
                                    @foreach($pedido->productos as $producto)
                                        <li class="list-group-item d-flex align-items-center">
                                            <img src="{{ $producto->imagen_url }}" class="img-thumbnail mr-3" style="width: 60px; height: 60px;">
                                            <div class="flex-grow-1">
                                                <strong>{{ $producto->nombre }}</strong><br>
                                                Cantidad: {{ $producto->pivot->cantidad }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <form action="{{ route('testing.pedidos.updateStatus', $pedido->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <x-adminlte-select name="status" label="Estado del pedido" onchange="this.form.submit()" class="form-control">
                                        <x-adminlte-options :options="[
                                            'pendiente' => 'Pendiente', 
                                            'enviado' => 'Enviado', 
                                            'entregado' => 'Entregado'
                                        ]" :selected="$pedido->status" />
                                    </x-adminlte-select>
                                </form>
                            @endif
                        </div>
                        <div class="card-footer text-muted text-right">
                            Última actualización: {{ $pedido->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
