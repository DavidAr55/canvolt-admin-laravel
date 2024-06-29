@extends('layouts.layout')

@section('title', 'Añadir artuculo al inventario')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Añadir articulo al inventario </h3>
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
                    <h4 class="card-title">Formulario para agregar articulos al inventario</h4>
                    <p class="card-description"> Nota: <i>recuerda no añadir productos que ya existan en el inventario</i> </p>
                    <form class="forms-sample" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="brand" name="brand" type="text" placeholder="Marca del producto" value="" required/>
                                    <label for="brand">Marca del producto</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Nombre del producto" value="" required/>
                                    <label for="name">Nombre del producto</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="description-min" name="description-min" type="text" placeholder="Descripción corta del producto" value="" required/>
                                    <label for="description-min">Descripción corta del producto</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="price" name="price" type="number" placeholder="Precio del producto" value="" required/>
                                    <label for="price">Precio del producto</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="discount" name="discount" type="number" step="0.01" min="0" max="99" placeholder="Ingresa el porcentaje de descuento" value="" required />
                                    <label for="discount">Porcentaje de descuento de compra</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">Categoría</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="condition" name="condition" required>
                                        <option value="" disabled selected>Selecciona la condición</option>
                                        <option value="new">Nuevo</option>
                                        <option value="used">Usado</option>
                                    </select>
                                    <label for="condition">Condición</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="" disabled selected>Selecciona el tipo</option>
                                        <option value="product">Producto</option>
                                        <option value="service">Servicio</option>
                                    </select>
                                    <label for="type">Tipo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="stock" name="stock" type="number" placeholder="Cantidad en inventario" value="" required/>
                                    <label for="stock">Cantidad en inventario</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto principal del producto</label>
                                    <input type="file" id="photo-main" name="photo-main" class="file-upload-default">
                                    <div class="input-group col-xs-12 d-flex align-items-center">
                                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                        <span class="input-group-append ms-2">
                                            <button class="file-upload-browse btn btn-primary" type="button">Subir imagen</button>
                                        </span>
                                    </div>
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
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6" id="photo-main-preview">
                                <!-- Mostrar imagen seleccionada -->
                            </div>
                            <div class="col-md-6" id="photos-preview">
                                <!-- Mostrar imagenes seleccionadas -->
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <textarea class="form-control" id="description" name="description" placeholder="Descripción del producto" style="height: 100px;" required></textarea>
                                    <label for="description">Descripción del producto</label>
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
<!-- content-wrapper ends -->
@endsection