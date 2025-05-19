@extends('testing.layouts.adminlte')

@section('title', 'Panel de Reportes')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="font-weight-bold">📊 Panel de Reportes de Ventas</h2>
            <p class="text-muted">Resumen general de la actividad comercial</p>
        </div>
    </div>

    {{-- Tarjetas resumen --}}
    <div class="row">
        <div class="col-md-3">
         <x-adminlte-info-box title="Ventas Totales"
                             text="{{ $productoMasVendido ? $topProductos->sum('total') . ' productos' : 'Sin ventas' }}"
                             icon="fas fa-shopping-basket"
                             theme="gradient-success" />
        </div>
        <div class="col-md-3">
         <x-adminlte-info-box title="Ingresos Generados"
                             text="${{ number_format($totalVentas, 2) }}"
                             icon="fas fa-coins"
                             theme="gradient-info" />
        </div>
        <div class="col-md-3">
         <x-adminlte-info-box title="Pendientes"
                             text="{{ $pedidosPendientes }} productos"
                             icon="fas fa-hourglass-half"
                             theme="gradient-warning" />
        </div>
        <div class="col-md-3">
         <x-adminlte-info-box title="Top Cliente"
                             text="{{ $usuarioMasCompras ? $usuarioMasCompras->usuario->name : 'Sin datos' }}"
                             icon="fas fa-user-tie"
                             theme="gradient-primary" />
        </div>
    </div>

    {{-- Sección de gráficos --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <x-adminlte-card title="📦 Productos más vendidos" theme="primary" icon="fas fa-chart-bar" collapsible>
                <canvas id="chartProductos"></canvas>
            </x-adminlte-card>
        </div>

        <div class="col-md-6">
            <x-adminlte-card title="🧑‍🤝‍🧑 Clientes destacados" theme="teal" icon="fas fa-users" collapsible>
                <canvas id="chartUsuarios"></canvas>
            </x-adminlte-card>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    const chartProductos = new Chart(document.getElementById('chartProductos'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProductos->pluck('producto.nombre')) !!},
            datasets: [{
                label: 'Vendidos',
                data: {!! json_encode($topProductos->pluck('total')) !!},
                backgroundColor: '#4e73df',
                borderRadius: 5
            }]
        },
        options: {
            plugins: {
                title: { display: true, text: 'Top Productos Vendidos' },
                legend: { display: false }
            },
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const chartUsuarios = new Chart(document.getElementById('chartUsuarios'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topUsuarios->pluck('usuario.name')) !!},
            datasets: [{
                label: 'Pedidos',
                data: {!! json_encode($topUsuarios->pluck('total')) !!},
                backgroundColor: '#fd7e14',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: {
                title: { display: true, text: 'Clientes con más pedidos' },
                legend: { display: false }
            },
            responsive: true,
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
