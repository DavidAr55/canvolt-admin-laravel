document.getElementById('send-form').addEventListener('click', function () {
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
            title: '¡Éxito!',
            text: 'Formulario enviado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    })
    .catch(error => {
        // Mostrar mensaje de error
        Swal.fire({
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });    
});
