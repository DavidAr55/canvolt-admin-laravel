@extends('layouts.layout')

@section('title', 'Panel de administración')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Servicios</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto" id="services-container">
                            <!-- service earnings -->
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-account-wrench-outline text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Productos vendidos</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto" id="products-container">
                            <!-- product sales container -->
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-cart-arrow-up text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Compras</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto" id="purchases-container">
                            <!-- Purchases container -->
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-cart-arrow-down text-danger ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" id="month-transactions-container">
                    <h4 class="card-title">Transacciones del mes</h4>
                    <div class="position-relative">
                        <div class="daoughnutchart-wrapper">
                            <canvas id="transaction-history" class="transaction-chart"></canvas>
                        </div>
                        <div class="custom-value">
                            <!-- Total transactions -->
                        </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-left">
                            <h6 class="mb-1">Transacciones de Servicios</h6>
                            <p class="text-muted mb-0">Mes actual</p>
                        </div>
                        <div class="align-self-center flex-grow text-end text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0 service-transaction-total"><!-- Service transactions --></h6>
                        </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-left">
                            <h6 class="mb-1">Transacciones de Productos Vendidos</h6>
                            <p class="text-muted mb-0">Mes actual</p>
                        </div>
                        <div class="align-self-center flex-grow text-end text-md-center text-xl-right py-md-2 py-xl-0">
                            <h6 class="font-weight-bold mb-0 product-transaction-total"><!-- Product sale transactions --></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estatus de servicios y ventas</h4>
                    <div class="table-responsive max-h-400">
                        <table class="table" id="service-and-product-sales">
                            <thead>
                                <tr>
                                    <th> Cliente </th>
                                    <th> Folio </th>
                                    <th> Cobro </th>
                                    <th> Servicio </th>
                                    <th> Pago </th>
                                    <th> País </th>
                                    <th> Fecha </th>
                                    <th> Estatus </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas se añadirán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Lista de tareas</h4>
                    <div class="add-items d-flex">
                        <input type="text" id="todo-input" class="form-control todo-list-input" placeholder="enter task..">
                        <button id="add-task-btn" class="add btn btn-primary todo-list-add-btn">Agregar</button>
                    </div>
                    <div class="list-wrapper">
                        <ul id="todo-list" class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
                            <!-- Tasks will be loaded here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ auth()->user()->branchOffice->name }} - Galeria</h4>
                    <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel" id="owl-carousel-basic">
                        <!-- Gallery will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ventas por país</h4>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="flag-icon flag-icon-mx"></i>
                                            </td>
                                            <td>México</td>
                                            <td class="text-end"> 1500 </td>
                                            <td class="text-end font-weight-medium"> 100% </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div id="audience-map" class="vector-map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
@endsection