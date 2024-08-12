@extends('layouts.layout')

@section('title', 'Administrador de Galería Canvolt')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Añadir imágenes a la galería </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('panel-de-control') }}">panel-de-control</a></li>
                <li class="breadcrumb-item active" aria-current="page">añadir-imagenes-galeria</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Formulario para agregar imágenes a la galería</h4>
                    <form class="forms-sample" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Título del conjunto</label>
                            <input type="text" name="title" class="form-control" placeholder="Título del conjunto">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Fotos</label>
                            <input type="file" id="photos" name="photos[]" class="file-upload-default" multiple>
                            <div class="input-group col-xs-12 d-flex align-items-center">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Subir imágenes">
                                <span class="input-group-append ms-2">
                                    <button class="file-upload-browse btn btn-primary" type="button">Subir imágenes</button>
                                </span>
                            </div>
                            @error('photos.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-4" id="photos_preview">
                            <!-- Mostrar imágenes seleccionadas -->
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Añadir a la galería</button>
                        <button type="button" class="btn btn-dark">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script para previsualizar las imágenes seleccionadas
        document.getElementById('photos').addEventListener('change', function(event) {
            var output = document.getElementById('photos_preview');
            output.innerHTML = '';
            var files = event.target.files;
            Array.from(files).forEach(function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var col = document.createElement('div');
                    col.classList.add('col-md-3');
                    col.classList.add('mb-4');
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100%';
                    col.appendChild(img);
                    output.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>

@endsection
