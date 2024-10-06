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
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0">$2039</h2>
                                <p class="text-danger ms-2 mb-0 font-weight-medium">-2.1% </p>
                            </div>
                            <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
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
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="check-all">
                                            </label>
                                        </div>
                                    </th>
                                    <th> Client Name </th>
                                    <th> Order No </th>
                                    <th> Product Cost </th>
                                    <th> Project </th>
                                    <th> Payment Mode </th>
                                    <th> Start Date </th>
                                    <th> Payment Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face1.jpg') }}" alt="image" />
                                        <span class="ps-2">Henry Klein</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> Dashboard </td>
                                    <td> Credit card </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-success">Approved</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face2.jpg') }}" alt="image" />
                                        <span class="ps-2">Estella Bryan</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> Website </td>
                                    <td> Cash on delivered </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-warning">Pending</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face5.jpg') }}" alt="image" />
                                        <span class="ps-2">Lucy Abbott</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> App design </td>
                                    <td> Credit card </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-danger">Rejected</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face3.jpg') }}" alt="image" />
                                        <span class="ps-2">Peter Gill</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> Development </td>
                                    <td> Online Payment </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-success">Approved</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face4.jpg') }}" alt="image" />
                                        <span class="ps-2">Sallie Reyes</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> Website </td>
                                    <td> Credit card </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-success">Approved</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/faces/face4.jpg') }}" alt="image" />
                                        <span class="ps-2">Sallie Reyes</span>
                                    </td>
                                    <td> 02312 </td>
                                    <td> $14,500 </td>
                                    <td> Website </td>
                                    <td> Credit card </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                        <div class="badge badge-outline-success">Approved</div>
                                    </td>
                                </tr>
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
                        <input type="text" class="form-control todo-list-input" placeholder="enter task..">
                        <button class="add btn btn-primary todo-list-add-btn">Add</button>
                    </div>
                    <div class="list-wrapper">
                        <ul class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
                            <li>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"> Create invoice </label>
                                </div>
                                <i class="remove mdi mdi-close-box"></i>
                            </li>
                            <li>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"> Meeting with Alita </label>
                                </div>
                                <i class="remove mdi mdi-close-box"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                                </div>
                                <i class="remove mdi mdi-close-box"></i>
                            </li>
                            <li>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"> Plan weekend outing </label>
                                </div>
                                <i class="remove mdi mdi-close-box"></i>
                            </li>
                            <li>
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                                </div>
                                <i class="remove mdi mdi-close-box"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Galeria principal</h4>
                    <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel" id="owl-carousel-basic">
                        <div class="item">
                            <img src="{{ asset('images/dashboard/Rectangle.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/dashboard/Img_5.jpg') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/dashboard/img_6.jpg') }}" alt="">
                        </div>
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
                                            <td class="text-end font-weight-medium"> 90% </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="flag-icon flag-icon-us"></i>
                                            </td>
                                            <td>Estados Unidos</td>
                                            <td class="text-end"> 500 </td>
                                            <td class="text-end font-weight-medium"> 10% </td>
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