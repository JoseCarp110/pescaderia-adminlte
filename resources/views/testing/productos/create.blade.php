@extends('testing.layouts.adminlte')

@section('title', 'Agregar Producto')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('testing.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Imagen -->
                    <div class="col-md-4 d-flex flex-column justify-content-center align-items-center" style="min-height: 100%;">
                        <img id="imagen_preview" src="https://placehold.co/300x300?text=Sin+Imagen&font=roboto" class="img-thumbnail mb-3" style="width: 100%; max-width: 300px; height: auto;">
                        <div class="form-group w-100">
                            <label for="imagen" class="text-center w-100">Seleccionar Imagen del Producto</label>
                            <input type="file" name="imagen" class="form-control-file @error('imagen') is-invalid @enderror" id="imagen" required>
                            @error('imagen')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Agregar Producto</h3>
                            </div>

                            <div class="card-body">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Producto</label>
                                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Descripción -->
                                <div class="form-group">
                                    <label for="descripcion">Descripción del Prodcuto</label>
                                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                                </div>

                                <!-- Categoría, Precio, Stock -->
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="categoria_id">Categoría</label>
                                        <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                                            <option value="">Selecciona una categoría</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                    {{ $categoria->nombre }}
                                                </option>
                                            @endforeach
                                            <option value="nueva_categoria">Agregar nueva categoría</option>
                                        </select>
                                        @error('categoria_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="precio">Precio</label>
                                        <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" step="0.01" min="0" required>
                                        @error('precio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="stock">Cantidad</label>
                                        <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}" min="0" required>
                                        @error('cantidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Oferta: Checkbox + Precio Oferta -->
                                <div class="form-row align-items-center mt-3">
                                    <div class="form-group col-md-4">
                                        <div class="custom-control custom-switch">
                                         <input type="checkbox" class="custom-control-input" id="es_oferta" name="es_oferta" value="1" {{ old('es_oferta') ? 'checked' : '' }} onchange="toggleOferta()">
                                         <label class="custom-control-label" for="es_oferta">Poner en Oferta</label>
                                    </div>
                                    </div>
                                    <div class="form-group col-md-4 ">
                                        <label for="precio_oferta">Precio de Oferta</label>
                                        <input type="number" name="precio_oferta" id="precio_oferta" class="form-control @error('precio_oferta') is-invalid @enderror" value="{{ old('precio_oferta') }}" step="0.01" min="0" {{ old('es_oferta') ? '' : 'disabled' }}>
                                        @error('precio_oferta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Guardar Producto</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('testing.productos.index') }}" class="btn btn-danger btn-block">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
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

    document.getElementById('categoria_id').addEventListener('change', function() {
        if (this.value === 'nueva_categoria') {
            window.location.href = "{{ route('categorias.create') }}";
        }
    });

    const categoriaSelect = document.getElementById('categoria_id');
    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', function() {
            if (this.value === 'nueva_categoria') {
                window.location.href = "{{ route('categorias.create') }}";
            }
        });
    }

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

