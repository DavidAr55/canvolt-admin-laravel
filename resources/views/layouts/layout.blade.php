<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="based-url" content="{{ config('app.url') }}">
    <meta name="sound-url" content="{{ asset('sound/message-13716.mp3') }}">
    <meta name="product-api" content="{{ config('app.canvolt') }}/api/v1/products-get-data">
    <meta name="branch-name" content="{{ auth()->user()->branchOffice->name }}">

    <!-- Custom meta tags -->
    @yield('meta')

    <title>@yield('title')</title>

    <!-- Layout SWAL2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- End Layout SWAL2 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- End Font Awesome -->

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @if (Request::is('generar-ticket'))
    <link rel="stylesheet" href="{{ asset('css/tickets/style.css') }}">
    @endif
    <!-- End Layout styles -->
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="{{ url('/panel') }}"><img src="{{ asset('images/logo.png') }}" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="{{ url('/panel') }}"><img style="width: 28px;" src="{{ asset('images/logo-mini.png') }}" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                                <span>{{ auth()->user()->branchOffice->name }}</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-cog text-primary"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Opciones de la cuenta</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-onepassword  text-info"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Cambiar contraseña</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-calendar-today text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Lista de tareas</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navegación</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ url('/panel') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Panel de control</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#tickets" aria-expanded="false" aria-controls="tickets">
                        <span class="menu-icon">
                            <i class="mdi mdi-ticket-confirmation-outline"></i>
                        </span>
                        <span class="menu-title">Tickets</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="tickets">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ url('/generar-ticket') }}">Generar ticket</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#inventory" aria-expanded="false" aria-controls="inventory">
                        <span class="menu-icon">
                            <i class="mdi mdi-server"></i>
                        </span>
                        <span class="menu-title">Inventario</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="inventory">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ url('/añadir-articulo') }}">Agregar al inventario</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ url('/inventario') }}">Inventario</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#canvolt-web" aria-expanded="false" aria-controls="canvolt-web">
                        <span class="menu-icon">
                            <i class="mdi mdi-code-block-tags"></i>
                        </span>
                        <span class="menu-title">Web de Canvolt</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="canvolt-web">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ url('/editar-slider-canvolt') }}">Editar el slider principal</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ url('/administrar-galeria') }}">Administrar la galeria</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="{{ url('/panel') }}"><img src="../../../{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input id="search-input" type="text" class="form-control" placeholder="Buscar productos" autocomplete="off">
                            </form>
                            <!-- Sección para mostrar los resultados de la búsqueda -->
                            <ul id="search-results" class="list-group mt-2 search-dropdown d-none"></ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <!-- Aquí el badge se actualizará dinámicamente -->
                                <span id="notification-badge" class="count bg-danger d-none"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                <h6 class="p-3 mb-0">Notificaciones</h6>
                                <div class="dropdown-divider"></div>
                                <div id="notification-list">
                                    <!-- Las notificaciones se agregarán dinámicamente aquí -->
                                </div>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center" id="no-notifications" class="d-none">No notifications</p>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Perfil</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-cog text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Ajustes</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content" onclick="redirectTo(`{{ url('/cerrar-sesion') }}`)">
                                        <p class="preview-subject mb-1">Cerrar sesión</p>
                                    </div>
                                </a>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">

                <!-- Content Section -->
                @yield('content')
                <!-- Content Section end -->

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a href="https://www.bootstrapdash.com/" target="_blank">Canvolt C.P</a>. Todos los derechos reservados.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('js/proBanner.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->

    <!-- Plugin js for this page -->
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page -->
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script src="{{ asset('js/typeahead.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/showImages.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/floating-form.js') }}"></script>
    <!-- End plugin js for this page -->
</body>

</html>