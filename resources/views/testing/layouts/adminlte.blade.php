<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('testing.partials.header')
</head>

@yield('scripts')

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('testing.partials.navbar')

    {{-- Sidebar --}}
    @include('testing.partials.sidebar')

    {{-- Contenido principal --}}
    <div class="content-wrapper p-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('testing.partials.footer')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @auth
        fetch('{{ route('carrito.contador') }}')
            .then(res => res.json())
            .then(data => {
                document.querySelector('#carrito-contador').textContent = data.count;
            });
        @endauth
    });
</script>

</body>
</html>

