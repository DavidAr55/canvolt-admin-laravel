<style>
    /* Estilos del formulario flotante */
    #floatingForm {
        width: 485px;
        position: fixed;
        top: 18vh;
        left: 14vw;
        background-color: #191c24;
        border: 1px solid #2c2e33;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        z-index: 100;
    }
    .form-header {
        cursor: move;
        background-color: #3D9555;
        color: white;
        padding: 10px;
        border-radius: 6px 6px 0 0;
    }
    .form-body {
        padding: 20px;
    }
    #minimizedForm {
        display: none;
        position: fixed;
        bottom: 0;
        left: 10px;
        background-color: #3D9555;
        color: white;
        padding: 10px;
        border-radius: 6px 6px 0 0;
        cursor: pointer;
        z-index: 100;
    }
    .minimize-btn {
        float: right;
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }
    .color-white::placeholder {
        color: white;
    }
    .form-select,
    .form-check .form-check-label {
        color: white !important; 
    }
    .textarea-control {
        height: 100px;
    }
    .italic {
        font-style: italic;
        color: #aaa;
    }
</style>

<!-- Formulario maximizado -->
<div id="floatingForm">
    <div class="form-header">
        Configuración del ticket
        <button class="minimize-btn" onclick="minimizeForm()"><i class="mdi mdi-minus-box-multiple-outline"></i></button>
    </div>
    <div class="form-body">
        <div class="container">
            <div class="row mb-3">
                <label for="ticket" class="col-sm-4 col-form-label text-end">Ticket:</label>
                <div class="col-sm-8 d-flex flex-row">
                    <div class="form-check form-check-primary me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticket" value="sale" checked> Venta <i class="input-helper"></i>
                        </label>
                    </div>
                    <div class="form-check form-check-info me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticket" value="quote"> Cotización <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="payment_method" class="col-sm-4 col-form-label text-end">Metodo de pago:</label>
                <div class="col-sm-8">
                    <select name="payment_method" id="payment_method" class="form-select color-white">
                        <option value="cash">Efectivo</option>
                        <option value="credit_card">Tarjeta de crédito</option>
                        <option value="debit_card">Tarjeta de débito</option>
                        <option value="bank_transfer">Transferencia bancaria</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="payment_terms" class="col-sm-4 col-form-label text-end">Plazos de pago:</label>
                <div class="col-sm-8">
                    <select name="payment_terms" id="payment_terms" class="form-select color-white">
                        <option value="1">1 pago</option>
                        <option value="3">3 pagos</option>
                        <option value="6">6 pagos</option>
                        <option value="12">12 pagos</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="extra_discount" class="col-sm-4 col-form-label text-end">Descuento extra:</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control color-white" id="extra_discount" value="0">
                </div>
            </div>
            <div class="row mb-3">
                <label for="details" class="col-sm-4 col-form-label text-end">Detalles:</label>
                <div class="col-sm-8">
                    <textarea name="details" class="form-control color-white textarea-control" id="details"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="country_code" class="col-sm-4 col-form-label text-end">Procedencia:</label>
                <div class="col-sm-8">
                    <select name="country_code" id="country_code" class="form-select color-white">
                        <!-- Opciones de países se cargarán con JavaScript -->
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="vehicleModel" class="col-sm-4 col-form-label text-end">Sucursal:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control color-white italic" id="vehicleModel" value="{{ auth()->user()->branchOffice->name }}" readonly>
                </div>
            </div>
            <input type="hidden" name="sale_type" id="sale_type" value="">
            <div class="row mb-3">
                <label for="ticketScale" class="col-sm-4 col-form-label text-end">Escala de Ticket:</label>
                <div class="col-sm-8 d-flex flex-row">
                    <!-- x0.5 Scale -->
                    <div class="form-check form-check-success me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticketScale" value="0.5"> x0.5 <i class="input-helper"></i>
                        </label>
                    </div>
                    <!-- x1 Scale (default) -->
                    <div class="form-check form-check-success me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticketScale" value="1" checked> x1 <i class="input-helper"></i>
                        </label>
                    </div>
                    <!-- x1.5 Scale -->
                    <div class="form-check form-check-success me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticketScale" value="1.5"> x1.5 <i class="input-helper"></i>
                        </label>
                    </div>
                    <!-- x2 Scale -->
                    <div class="form-check form-check-success me-3">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="ticketScale" value="2"> x2 <i class="input-helper"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario minimizado -->
<div id="minimizedForm" onclick="maximizeForm()">
    Configuración del ticket <i class="mdi mdi-window-maximize"></i>
</div>

<script>
    // Escuchar cambios en los radio buttons
    const radios = document.querySelectorAll('input[name="ticketScale"]');
    const ticketContainer = document.getElementById('ticketContainer');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            // Obtener el valor seleccionado
            const scale = parseFloat(this.value);

            // Aplicar el nuevo valor de las variables CSS
            document.documentElement.style.setProperty('--ticket-width', `${595 * scale}px`);
            document.documentElement.style.setProperty('--ticket-height', `${842 * scale}px`);
            document.documentElement.style.setProperty('--ticket-margin', `${25 * scale}px 0`);

            document.documentElement.style.setProperty('--p-text-font-size', `${10 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-p-padding', `${0 * scale}px ${5 * scale}px`);

            document.documentElement.style.setProperty('--ticket-img-logo-width', `${142 * scale}px`);
            document.documentElement.style.setProperty('--ticket-img-logo-top', `${16.89 * scale}px`);
            document.documentElement.style.setProperty('--ticket-img-logo-left', `${14 * scale}px`);

            document.documentElement.style.setProperty('--ticket-watermark-width', `${453.54 * scale}px`);
            document.documentElement.style.setProperty('--ticket-watermark-height', `${450.02 * scale}px`);
            document.documentElement.style.setProperty('--ticket-watermark-top', `${141.73 * scale}px`);
            document.documentElement.style.setProperty('--ticket-watermark-left', `${70.86 * scale}px`);

            document.documentElement.style.setProperty('--ticket-folio-section-top', `${33.85 * scale}px`);
            document.documentElement.style.setProperty('--ticket-folio-section-right', `${17.39 * scale}px`);
            document.documentElement.style.setProperty('--ticket-folio-section-h1-font-size', `${24 * scale}px`);

            document.documentElement.style.setProperty('--ticket-info-section-top', `${72.06 * scale}px`);
            document.documentElement.style.setProperty('--ticket-info-section-left', `${30.42 * scale}px`);

            document.documentElement.style.setProperty('--ticket-client-section-top', `${167.59 * scale}px`);
            document.documentElement.style.setProperty('--ticket-client-section-left', `${30.42 * scale}px`);

            document.documentElement.style.setProperty('--ticket-client-section-h4-font-size', `${12 * scale}px`);
            document.documentElement.style.setProperty('--ticket-client-section-h4-margin-bottom', `${12.5 * scale}px`);
            
            document.documentElement.style.setProperty('--ticket-date-section-top', `${80.86 * scale}px`);
            document.documentElement.style.setProperty('--ticket-date-section-right', `${14.17 * scale}px`);

            document.documentElement.style.setProperty('--ticket-date-box-padding', `${6.81 * scale}px ${12.45 * scale}px`);

            document.documentElement.style.setProperty('--ticket-table-container-top', `${269.29 * scale}px`);
            document.documentElement.style.setProperty('--ticket-table-container-width', `${538.58 * scale}px`);
            
            document.documentElement.style.setProperty('--ticket-table-container-th-padding', `${8 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-product-width', `${281.22 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-product-height', `${34.01 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-quantity-width', `${28.34 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-quantity-height', `${34.01 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-price-width', `${85.03 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-price-height', `${34.01 * scale}px`);

            document.documentElement.style.setProperty('--ticket-footer-acknowledgments-top', `${621.34 * scale}px`);
            document.documentElement.style.setProperty('--ticket-footer-acknowledgments-width', `${538.58 * scale}px`);
            document.documentElement.style.setProperty('--ticket-footer-acknowledgments-height', `${30.34 * scale}px`);
            document.documentElement.style.setProperty('--ticket-footer-acknowledgments-h3-font-size', `${14 * scale}px`);

            document.documentElement.style.setProperty('--ticket-footer-text-top', `${664.84 * scale}px`);

            document.documentElement.style.setProperty('--ticket-img-icon-width', `${85.03 * scale}px`);
            document.documentElement.style.setProperty('--ticket-img-icon-height', `${84.53 * scale}px`);
            document.documentElement.style.setProperty('--ticket-img-icon-margin-top', `${5 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-contact-width', `${250 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-p-font-size', `${10 * scale}px`);

            document.documentElement.style.setProperty('--ticket-input-h-width', `${538.58 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-h-height', `${34.01 * scale}px`);
            document.documentElement.style.setProperty('--ticket-input-h-font-size', `${14 * scale}px`);

            document.documentElement.style.setProperty('--ticket-add-row-font-size', `${10 * scale}px`);
            document.documentElement.style.setProperty('--ticket-add-row-width', `${25 * scale}px`);
            document.documentElement.style.setProperty('--ticket-add-row-height', `${25 * scale}px`);

            document.documentElement.style.setProperty('--ticket-delete-row-font-size', `${10 * scale}px`);
            document.documentElement.style.setProperty('--ticket-delete-row-width', `${25 * scale}px`);
            document.documentElement.style.setProperty('--ticket-delete-row-height', `${25 * scale}px`);

            document.documentElement.style.setProperty('--ticket-suggestions-max-height', `${300 * scale}px`);
            document.documentElement.style.setProperty('--ticket-suggestions-margin-top', `${5 * scale}px`);

            document.documentElement.style.setProperty('--ticket-total-discount-margin-top', `${5 * scale}px`);

            document.documentElement.style.setProperty('--ticket-buttons-container-bottom', `${25 * scale}px`);
            document.documentElement.style.setProperty('--ticket-buttons-container-right', `${25 * scale}px`);

            document.documentElement.style.setProperty('--ticket-initial-x', `${608.53 * scale}px`);
            document.documentElement.style.setProperty('--ticket-initial-y', `${36.45 * scale}px`);
        });
    });
</script>