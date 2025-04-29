@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row w-100">
        <!-- Imagen del producto + input -->
        <div class="col-md-4 d-flex flex-column align-items-center" style="margin-top: 120px;">
            <!-- Vista previa -->
            <img id="imagen_preview" src="https://placehold.co/300x300?text=Sin+Imagen&font=roboto" alt="Vista previa de la imagen" class="img-thumbnail mb-3" style="width: 100%; max-width: 300px; height: auto;">

            <!-- Input de imagen -->
            <div class="form-group w-100 px-3">
                <label for="imagen" class="text-center w-100">Seleccionar Imagen del Producto</label>
                <input type="file" name="imagen" class="form-control-file" id="imagen" required>
            </div>
        </div>

        <!-- Formulario para agregar producto -->
        <div class="col-md-8">
            <h1 class="text-center my-4">Agregar Producto</h1>

            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nombre -->
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}" required>
                </div>

                <!-- Descripción -->
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                </div>

                <!-- Categoría, Precio y Cantidad -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="categoria_id">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-control">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                            <option value="nueva_categoria">Agregar nueva categoría</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio" value="{{ old('precio') }}" required step="0.01">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" id="cantidad" value="{{ old('cantidad') }}" required min="0">
                    </div>
                </div>

                <!-- Oferta -->
                <div class="form-row align-items-center mt-4" style="max-width: 600px;">
                    <div class="form-group col-auto">
                        <label for="es_oferta" class="mr-2">Poner en Oferta</label>
                        <input type="checkbox" name="es_oferta" id="es_oferta" value="1" {{ old('es_oferta') ? 'checked' : '' }} onchange="toggleOferta()">
                    </div>
                    <div class="form-group col-auto d-flex align-items-center" style="margin-left: 20px;">
                        <label for="precio_oferta" class="mr-2" style="margin-right: 10px;">Precio de Oferta</label>
                        <input type="number" name="precio_oferta" id="precio_oferta" class="form-control" value="{{ old('precio_oferta') }}" style="width: 150px;" disabled>
                    </div>
                </div>

                <!-- Botones -->
                <button type="submit" class="btn btn-primary mt-4">Agregar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-danger mt-4">Cancelar</a>
            </form>
        </div>
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

    // Redirigir si selecciona "Agregar nueva categoría"
    document.getElementById('categoria_id').addEventListener('change', function() {
        if (this.value === 'nueva_categoria') {
            window.location.href = "{{ route('categorias.create') }}";
        }
    });

    // Previsualización de imagen
    document.getElementById('imagen').addEventListener('change', function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagen_preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection


