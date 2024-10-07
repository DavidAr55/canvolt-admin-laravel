@extends('layouts.layout')

@section('title', 'Añadir artículo al inventario')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Añadir artículo al inventario </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('panel-de-control') }}">panel-de-control</a></li>
                <li class="breadcrumb-item active">inventario</li>
                <li class="breadcrumb-item active" aria-current="page">añadir-articulo</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Agregar artículos al inventario</h4>
                    <p class="card-description"> Nota: <i>recuerda no añadir productos que ya existan en el inventario</i> </p>
                    <form class="forms-sample" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="brand" name="brand" type="text" placeholder="Marca del producto" value="{{ old('brand') }}" />
                                    <label for="brand">Marca del producto</label>
                                    @error('brand')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Nombre del producto" value="{{ old('name') }}" />
                                    <label for="name">Nombre del producto</label>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="description_min" name="description_min" type="text" placeholder="Descripción corta del producto" value="{{ old('description_min') }}" />
                                    <label for="description_min">Descripción corta del producto</label>
                                    @error('description_min')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 category-wrapper">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-control" id="category_id" name="category_id" onchange="toggleServiceDropdown()">
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">Categoría</label>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 service-dropdown" style="display: none;">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-control" id="service_option" name="service_option" onchange="togglePriceInputs()">
                                        <option value="" disabled selected>Selecciona si es un servicio también</option>
                                        <option value="0">No es un servicio</option>
                                        <option value="1">Servicio</option>
                                    </select>
                                    <label for="service_option">¿Es un servicio?</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="condition" name="condition" >
                                        <option value="" disabled selected>Selecciona la condición</option>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Nuevo</option>
                                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Usado</option>
                                    </select>
                                    <label for="condition">Condición</label>
                                    @error('condition')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4" id="price-row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="price" name="price" type="number" placeholder="Precio del Producto" value="{{ old('price') }}" />
                                    <label for="price">Precio del Producto</label>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="discount" name="discount" type="number" step="0.01" min="0" max="99" placeholder="Descuento de Compra" value="{{ old('discount') }}" />
                                    <label for="discount">Descuento de Compra (%)</label>
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4" id="service-price-row" style="display: none;">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input class="form-control" id="secundary_price" name="" type="number" placeholder="Precio del Producto" value="{{ old('price') }}" />
                                    <label for="secundary_price">Precio del Producto</label>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input class="form-control" id="instalation_price" name="instalation_price" type="number" placeholder="Precio del Producto e Instalación" value="{{ old('instalation_price') }}" />
                                    <label for="instalation_price">Precio e Instalación</label>
                                    @error('instalation_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="secundary_discount" name="" type="number" step="0.01" min="0" max="99" placeholder="Descuento del Producto" value="{{ old('discount') }}" />
                                    <label for="secundary_discount">Descuento del Producto (%)</label>
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="instalation_discount" name="instalation_discount" type="number" step="0.01" min="0" max="99" placeholder="Descuento del Servicio" value="{{ old('instalation_discount') }}" />
                                    <label for="instalation_discount">Descuento del Servicio (%)</label>
                                    @error('instalation_discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input class="form-control" id="stock" name="stock" type="number" placeholder="Cantidad en inventario" value="{{ old('stock') }}" />
                                    <label for="stock">Cantidad en inventario</label>
                                    @error('stock')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto principal del producto</label>
                                    <input type="file" id="photo_main" name="photo_main" class="file-upload-default">
                                    <div class="input-group col-xs-12 d-flex align-items-center">
                                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                        <span class="input-group-append ms-2">
                                            <button class="file-upload-browse btn btn-primary" type="button">Subir imagen</button>
                                        </span>
                                    </div>
                                    @error('photo_main')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fotos del producto</label>
                                    <input type="file" id="photos" name="photos[]" class="file-upload-default" multiple>
                                    <div class="input-group col-xs-12 d-flex align-items-center">
                                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                        <span class="input-group-append ms-2">
                                            <button class="file-upload-browse btn btn-primary" type="button">Subir imagenes</button>
                                        </span>
                                    </div>
                                    @error('photos.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6" id="photo_main_preview">
                                <!-- Mostrar imagen seleccionada -->
                            </div>
                            <div class="col-md-6" id="photos_preview">
                                <!-- Mostrar imagenes seleccionadas -->
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <textarea class="form-control" id="description" name="description" placeholder="Descripción del producto" style="height: 100px;" >{{ old('description') }}</textarea>
                                    <label for="description">Descripción del producto</label>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Añadir al inventario</button>
                        <button type="button" class="btn btn-dark">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('category_id').addEventListener('change', toggleServiceDropdown);
        document.getElementById('service_option').addEventListener('change', togglePriceInputs);

        function toggleServiceDropdown() {
            var categorySelect = document.getElementById('category_id');
            var serviceDropdown = document.querySelector('.service-dropdown');
            var categoryWrapper = document.querySelector('.category-wrapper');

            var PIEZAS_ID = 2; // Cambia esto al ID correcto para la categoría "Piezas"

            if (categorySelect.value == PIEZAS_ID) {
                categoryWrapper.classList.remove('col-md-6');
                categoryWrapper.classList.add('col-md-3');
                serviceDropdown.style.display = 'block';
            } else {
                categoryWrapper.classList.remove('col-md-3');
                categoryWrapper.classList.add('col-md-6');
                serviceDropdown.style.display = 'none';

                // Resetear la selección del dropdown de servicio
                document.getElementById('service_option').value = "";

                // Restablecer el formulario a su estado normal
                document.getElementById('price-row').style.display = 'flex';
                document.getElementById('service-price-row').style.display = 'none';
            }
        }

        function togglePriceInputs() {
            var serviceOption = document.getElementById('service_option').value;
            var priceRow = document.getElementById('price-row');
            var servicePriceRow = document.getElementById('service-price-row');

            if (serviceOption == "1") {
                priceRow.style.display = 'none';
                servicePriceRow.style.display = 'flex';

                // Asignamos nombre a los inputs de "secundary_price" y "secundary_discount"
                document.getElementById('secundary_price').name = 'price';
                document.getElementById('secundary_discount').name = 'discount';

                // Desasignamos nombre a los inputs de "price" y "discount"
                document.getElementById('price').name = '';
                document.getElementById('discount').name = '';
            } else {
                priceRow.style.display = 'flex';
                servicePriceRow.style.display = 'none';

                // Desasignamos nombre a los inputs de "secundary_price" y "secundary_discount"
                document.getElementById('secundary_price').name = '';
                document.getElementById('secundary_discount').name = '';

                // Asignamos nombre a los inputs de "price" y "discount"
                document.getElementById('price').name = 'price';
                document.getElementById('discount').name = 'discount';
            }
        }
    });
</script>
<!-- content-wrapper ends -->
@endsection
