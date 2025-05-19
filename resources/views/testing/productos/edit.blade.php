@extends('testing.layouts.adminlte')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Producto</h4>
                </div>
                <!-- ETIQUETA DE ERRORES -->
                <div class="card-body">
              <!--  @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif -->
                    <form action="{{ route('testing.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Imagen -->
                           <!-- <div class="col-md-4 d-flex flex-column align-items-center"> VER SI ME GUSTA EL DISEÑO-->
                            <div class="col-md-4 d-flex flex-column justify-content-center align-items-center" style="min-height: 100%;">
                                <img id="current-image"
                                    src="{{ $producto->imagen_url }}"
                                    class="img-thumbnail mb-3"
                                    style="width: 100%; max-width: 300px; height: auto; display: {{ $producto->imagen_url ? 'block' : 'none' }};">
                                <div id="no-image" class="text-muted mb-3" style="display: {{ $producto->imagen_url ? 'none' : 'block' }};">No hay imagen disponible</div>

                                <div class="form-group w-100">
                                    <label for="imagen" class="text-center w-100">Cambiar Imagen</label>
                                    <input type="file" name="imagen" class="form-control-file" id="imagen" onchange="previewImage(event)">
                                </div>
                            </div>

                            <!-- Campos -->
                            <div class="col-md-8">
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
                                     <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror">
                                        <option value="">Selecciona una categoría</option>
                                        @foreach($categorias as $categoria)
                                          <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                          </option>
                                        @endforeach
                                        <option value="nueva_categoria">Agregar nueva categoría</option>
                                     </select>
                                        @error('categoria_id')
                                          <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                 </div>
                                 <div class="form-group col-md-4">
                                      <label for="precio">Precio</label>
                                      <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror" id="precio" value="{{ old('precio', $producto->precio) }}" required min="0" step="1">
                                         @error('precio')
                                           <div class="invalid-feedback d-block">{{ $message }}</div>
                                         @enderror
                                 </div>
                                 <div class="form-group col-md-4">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" id="cantidad" value="{{ old('cantidad', $producto->cantidad) }}"
                                      required min="1">
                                    @error('cantidad')
                                      <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                               
                              <!-- Oferta: Checkbox + Precio Oferta -->
                              <div class="form-row align-items-center mt-3">
                                 <!-- Checkbox como switch -->
                                <div class="form-group col-md-4">
                                   <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" id="es_oferta" name="es_oferta" value="1"
                                        {{ old('es_oferta', $producto->es_oferta) ? 'checked' : '' }} onchange="toggleOferta()">
                                      <label class="custom-control-label" for="es_oferta">Poner en Oferta</label>
                                  </div>
                                </div>
                                 <!-- Precio de Oferta -->
                                <div class="form-group col-md-4">
                                   <label for="precio_oferta">Precio de Oferta</label>
                                   <input type="number" name="precio_oferta" id="precio_oferta"
                                     class="form-control @error('precio_oferta') is-invalid @enderror"
                                     value="{{ old('precio_oferta', $producto->precio_oferta) }}"
                                     step="0.01" min="0" {{ old('es_oferta', $producto->es_oferta) ? '' : 'disabled' }}>
                                       @error('precio_oferta')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                </div>
                               </div>                       

                                <!-- Botones alineados con los campos -->
                                <div class="form-group mt-4">
                                    <div class="row">
                                      <div class="col-md-6 mb-2">
                                         <button type="submit" class="btn btn-primary w-100">Actualizar Producto</button>
                                      </div>
                                      <div class="col-md-6 mb-2">
                                         <a href="{{ route('testing.productos.index') }}" class="btn btn-danger w-100">Cancelar</a>
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

<script>
    
    document.querySelector('form').addEventListener('submit', function (e) {
        const categoria = document.getElementById('categoria_id').value;
        const precio = parseFloat(document.getElementById('precio').value);

        if (categoria === '') {
            alert('Debe seleccionar una categoría válida.');
            e.preventDefault();
            return;
        }

        if (precio <= 0 || isNaN(precio)) {
            alert('El precio debe ser mayor a 0.');
            e.preventDefault();
            return;
        }
    });

    function toggleOferta() {
        const ofertaCheckbox = document.getElementById('es_oferta');
        const precioOfertaInput = document.getElementById('precio_oferta');
        precioOfertaInput.disabled = !ofertaCheckbox.checked;
    }

    window.onload = toggleOferta;

    document.getElementById('categoria_id').addEventListener('change', function () {
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
            reader.onload = function (e) {
                currentImage.src = e.target.result;
                currentImage.style.display = 'block';
                noImage.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            currentImage.src = '';
            currentImage.style.display = 'none';
            noImage.style.display = 'block';
        }
    }
</script>
@endsection
