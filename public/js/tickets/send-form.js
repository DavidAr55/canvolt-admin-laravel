document.getElementById('send-form').addEventListener('click', function () {
    // Obtenemos la configuración del ticket
    const ticket = document.querySelector('input[name="ticket"]:checked').value;
    const country_code = document.getElementById('country_code').value;
    const payment_method = document.getElementById('payment_method').value;
    const extra_discount = document.getElementById('extra_discount').value;
    const details = document.getElementById('details').value;
    const sale_type = document.getElementById('sale_type').value;

    // Obtenemos los valores de los meta tags
    const form_route = document.head.querySelector('meta[name="form-route"]').content;
    const csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;

    // Seleccionamos los inputs
    const name = document.querySelector('input[name="name"]').value;
    const contact = document.querySelector('input[name="contact"]').value;
    const acknowledgments = document.querySelector('input[name="acknowledgments"]').value;

    // Obtenemos los valores de las filas de la tabla
    const products = Array.from(document.querySelectorAll('input[name="product[]"]')).map(input => input.value);
    const quantities = Array.from(document.querySelectorAll('input[name="quantity[]"]')).map(input => input.value);
    const prices = Array.from(document.querySelectorAll('input[name="price[]"]')).map(input => input.value);

    // Creamos un objeto con los datos
    const formData = {
        name: name,
        contact: contact,
        acknowledgments: acknowledgments,
        product: products,
        quantity: quantities,
        price: prices,
        ticket: ticket,
        country_code: country_code,
        sale_type: sale_type,
        payment_method: payment_method,
        extra_discount: extra_discount,
        details: details,
    };

    // Hacemos la solicitud a Laravel usando fetch
    fetch(form_route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf_token
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        // Verificar si la respuesta es JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();  // Parsear JSON
        } else {
            throw new Error('Respuesta no es JSON');
        }
    })
    .then(data => {
        // Mostrar mensaje de éxito
        Swal.fire({
            title: '¡Listo!',
            text: 'El ticket se ha generado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    })
    .catch(error => {
        // Mostrar mensaje de error
        Swal.fire({
            title: '¡Ups!',
            text: error.message || 'Ocurrió un error inesperado.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });    
});
