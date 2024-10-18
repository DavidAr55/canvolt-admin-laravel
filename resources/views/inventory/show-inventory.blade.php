@extends('layouts.layout')

@section('title', 'Inventario')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Inventario </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('panel-de-control') }}">panel-de-control</a></li>
                <li class="breadcrumb-item active">inventario</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Inventario</h4>
                    <p class="card-description"> Inventario de productos</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Ingresado</th>
                                    <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($inventories as $inventory)
                                    <tr>
                                        <td><img src="{{ asset('storage/' . $inventory->product->photo_main) }}" alt="{{ $inventory->product->name }}" style="width: 70px; height: auto;"></td>
                                        <td>{{ $inventory->product->brand }}</td>
                                        <td>{{ $inventory->product->name }}</td>
                                        <td>{{ $inventory->stock }}</td>
                                        <td>${{ number_format($inventory->product->price, 2) }}</td>
                                        <td>{{ $inventory->created_at->format('d-m-Y') }}</td>
                                        <td>
                                        <!-- Botones de acciones (editar, eliminar, etc.) -->
                                        <a href="{{ route('inventario.edit', $inventory->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <form action="{{ route('inventario.destroy', $inventory->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form> 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
