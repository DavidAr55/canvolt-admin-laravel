@extends('layouts.layout')

@section('title', 'Editar el slider de la pagina principal')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Editar el slider de la pagina principal </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('panel-de-control') }}">panel-de-control</a></li>
                <li class="breadcrumb-item active">formulario-canvolt</li>
                <li class="breadcrumb-item active" aria-current="page">slider-canvolt</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Formulario para editar el slider principal</h4>
                    <p class="card-description"> Nota: <i>recuerda no añadir productos que ya existan en el inventario</i> </p>
                    <form class="forms-sample" action="{{ route('canvolt-form.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5 class="card-title">Scooters que se muestran en el slider de la web:</h5>
                        <div class="row mb-4">
                            @php
                                $totalProducts = count($sliders);
                            @endphp

                            <div class="row mb-4">
                                @foreach($sliders as $slider)
                                    <div class="col-md-3">
                                        {{ $slider }}
                                    </div>
                                @endforeach

                                @for ($i = $totalProducts; $i < 4; $i++)
                                    <div class="col-md-3 d-flex align-items-center justify-content-center text-center">
                                        <div class="alert alert-success" role="alert">
                                            <h3>¡vacío!</h3>
                                            <p>Puedes usar este espacio para mostrar un scooter en el slider de canvolt.com.mx</p>
                                        </div>
                                    </div>
                                @endfor
                            </div> 
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Seleccionar otros o más scooters del inventario:</label>
                                    <select name="selected_products[]" class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach  
                                    </select>
                                </div>           
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Añadir al carrusel</button>
                        <button type="button" class="btn btn-dark">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
@endsection