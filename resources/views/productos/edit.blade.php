@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row w-100 position-relative">

        <!-- Formulario para editar un producto -->
        <form id="formProducto" action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="col-md-12 d-flex">
            @csrf
            @method('PUT')

            <!-- Columna izquierda: Imagen -->
            <div class="col-md-4 d-flex flex-column align-items-center" style="margin-top: 120px;">
                <img id="current-image"
                    src="{{ $producto->imagen_url }}"
                    alt="{{ $producto->nombre }}"
                    class="img-thumbnail mb-3"
                    style="width: 100%; max-width: 300px; height: auto; display: {{ $producto->imagen_url ? 'block' : 'none' }};">
                <div id="no-image" class="text-muted mb-3" style="display: {{ $producto->imagen_url ? 'none' : 'block' }};">No hay imagen disponible</div>

                <!-- Input de imagen (DENTRO del form pero se ve como si estuviera aparte) -->
                <div class="form-group w-100 px-3">
                    <label for="imagen" class="text-center w-100">Cambiar Imagen</label>
                    <input type="file" name="imagen" class="form-control-file" id="imagen" onchange="previewImage(event)">
                </div>
            </div>

            <!-- Columna derecha: Formulario de edición -->
            <div class="col-md-8">
                <h1 class="text-center my-4">Editar Producto</h1>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="categoria_id">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-control">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                            <option value="nueva_categoria">Agregar nueva categoría</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio" value="{{ old('precio', $producto->precio) }}" required step="0.01">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" id="cantidad" value="{{ old('cantidad', $producto->cantidad) }}" required min="0">
                    </div>
                </div>

                <div class="form-row align-items-center mt-4" style="max-width: 600px;">
                    <div class="form-group col-auto">
                        <label for="es_oferta" class="mr-2">Poner en Oferta</label>
                        <input type="checkbox" name="es_oferta" id="es_oferta" value="1" {{ old('es_oferta', $producto->es_oferta) ? 'checked' : '' }} onchange="toggleOferta()">
                    </div>
                    <div class="form-group col-auto d-flex align-items-center" style="margin-left: 20px;">
                        <label for="precio_oferta" class="mr-2" style="margin-right: 10px;">Precio de Oferta</label>
                        <input type="number" name="precio_oferta" id="precio_oferta" class="form-control" value="{{ old('precio_oferta', $producto->precio_oferta) }}" style="width: 150px;" {{ $producto->es_oferta ? '' : 'disabled' }}>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Actualizar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-4">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleOferta() {
        const ofertaCheckbox = document.getElementById('es_oferta');
        const precioOfertaInput = document.getElementById('precio_oferta');
        precioOfertaInput.disabled = !ofertaCheckbox.checked;
    }

    window.onload = function() {
        toggleOferta();
    };

    document.getElementById('categoria_id').addEventListener('change', function() {
        if (this.value === 'nueva_categoria') {
            window.location.href = "{{ route('categorias.create') }}";
        }
    });

    function previewImage(event) {
        const input = event.target;
        const currentImage = document.getElementById('current-image');
        const noImage = document.getElementById('no-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentImage.src = e.target.result;
                currentImage.style.display = 'block';
                noImage.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            currentImage.src = '';
            currentImage.style.display = 'none';
            noImage.style.display = 'block';
        }
    }
</script>
@endsection

