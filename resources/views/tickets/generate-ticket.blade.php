@extends('layouts.layout')

@section('title', 'Generar ticket para cliente')

@section('content')

@include('layouts.alerts')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Generar ticket para cliente </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('panel-de-control') }}">panel-de-control</a></li>
                <li class="breadcrumb-item active">tickets</li>
                <li class="breadcrumb-item active" aria-current="page">generar-ticket</li>
            </ol>
        </nav>
    </div>
    <div class="row justify-content-center">
        <main class="d-grid" id="main-container">
            <div class="ticket-section">
                <div class="container">
                    <img src="{{ asset('images/canvolt-water-mark.png') }}" alt="Canvolt marca de agua" class="watermark">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Canvolt" class="img-logo">

                    <div class="folio-section">
                        <h1>FOLIO No. {{ next_folio() }}</h1>
                    </div>

                    <div class="info-section p">
                        <p>C. Juan Manuel 304</p>
                        <p>Zapopan, 45100 Zapopan, Jal.</p>
                        <p>Teléfono: +52 33 3258 8070</p>
                        <p>Sitio web: www.canvolt.com.mx</p>
                    </div>

                    <div class="date-section p">
                        <span class="me-2 mt-1">FECHA:</span>
                        <div class="date-box p">
                            <p class="mt-2">{{ current_date_spanish() }}</p>
                        </div>
                    </div>

                    <div class="client-section p">
                        <h4>Datos del Comprador</h4>
                        <p>Nombre: <input type="text" name="name" value="David Loera Olmos" title="Nombre del comprador" required class="input-p input-contact"></p>
                        <p>Contacto: <input type="text" name="contact" value="davidarturoloera@gmail.com" title="Conacto del comprador WhatsApp/Email" required class="input-p input-contact"></p>
                    </div>

                    <div class="table-container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="p">
                                        <p>#</p>
                                    </th>
                                    <th scope="col" class="p">
                                        <p>Producto o servicio</p>
                                    </th>
                                    <th scope="col" class="p">
                                        <p>C</p>
                                    </th>
                                    <th scope="col" class="p">
                                        <p>Precio unitario</p>
                                    </th>
                                    <th scope="col" class="p">
                                        <p>Total</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <tr id="row-1">
                                    <td class="p">
                                        <p class="counter">1</p>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="product[]" value="" title="Producto o servicio" required class="input-p input-product">
                                        <div class="suggestions hidden"></div>
                                    </td>
                                    <td class="p-0"><input type="number" name="quantity[]" value="1" title="Cantidad unitaria" required class="input-p input-quantity"></td>
                                    <td class="p-0">
                                        <input type="number" name="price[]" value="" title="Precio unitario" required class="input-p input-price">
                                    </td>
                                    <td class="p">
                                        <p class="total">$0.00 MX</p>
                                        <span class="total-discount"></span>
                                    </td>
                                </tr>
                                <!-- Aquí se añadirán las nuevas filas -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="p">
                                        <h4>Total: </h4>
                                    </td>
                                    <td colspan="1" class="p">
                                        <p id="final-total">$0.00 MX</p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Contenedor del botón -->
                        <div class="row-actions" id="row-actions">
                            <!-- Botón para añadir una fila -->
                        </div>
                    </div>

                    <label for="">
                        <div class="footer-acknowledgments">
                            <h3><input type="text" name="acknowledgments" value="¡Gracias por confiar en nosotros!" title="Mensaje de agradecimiento" required class="input-h input-contact"></h3>
                        </div>
                    </label>

                    <footer class="footer-text p text-center">
                        <p>Para cualquier pregunta o problema, por favor contáctanos.</p>
                        <div class="p-2"></div>
                        <p>Email: contacto@canvolt.com.mx</p>
                        <p>Teléfono: +52 33 3258 8070</p>
                        <img src="{{ asset('images/logo-mini.png') }}" alt="icono Canvolt" class="img-icon">
                    </footer>
                    
                    <div class="buttons-container">
                        <button class="btn btn-primary" id="send-form">Generar ticket</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script> var form_route = "{{ route('tickets.store') }}"; </script>
<script> var csrf_token = "{{ csrf_token() }}"; </script>
<script src="{{ asset('js/tickets/main.js') }}"></script>
<script src="{{ asset('js/tickets/send-form.js') }}"></script>

<!-- content-wrapper ends -->
@endsection