document.addEventListener('DOMContentLoaded', function() {
    // Renderizar el botón inicial
    renderButton(xInitial, yInitial);
    // Cargar productos de la API
    fetchProducts();
});

var xInitial = 608.53;
var yInitial = 36.45;

let products = [];
let openSuggestions = null; // Controlar si las sugerencias están abiertas
let globalRowCounter = 2; // Contador global para las filas

// Formatear número en formato moneda MXN
const formatCurrency = (value) => {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2
    }).format(value);
};

// Función para cargar los productos
function fetchProducts() {
    fetch('http://127.0.0.1:8000/api/v1/products-get-data')
        .then(response => response.json())
        .then(data => {
            products = data;
        });
}

// Renderiza el botón inicial para agregar filas
function renderButton(x, y) {
    let button = document.createElement('button');
    button.classList.add('add-row');
    button.innerHTML = '<i class="fa-solid fa-plus"></i>';
    button.style.left = x + 'px';
    button.style.top = y + 'px';

    // Añadir evento click al botón
    button.addEventListener('click', addRow);

    document.querySelector('#row-actions').appendChild(button);
}

function addRow() {
    const mainContainer = document.querySelector('#main-container');
    const tbody = document.querySelector('#table-body');
    const rowCount = tbody.querySelectorAll('tr').length + 1; // Número actual de filas visibles

    let newRow = document.createElement('tr');
    newRow.id = `row-${globalRowCounter}`; // Usamos el contador global para el ID único de la fila

    newRow.innerHTML = `
        <td class="p"><p class="counter">${rowCount}</p></td>
        <td class="p-0" style="position: relative;">
            <input type="text" name="product[]" value="" title="Descripción del producto/servicio" required class="input-p input-product">
            <div class="suggestions hidden"></div>
        </td>
        <td class="p-0"><input type="number" name="quantity[]" value="1" title="Cantidad unitaria" required class="input-p input-quantity" min="1"></td>
        <td class="p-0">
            <input type="number" name="price[]" value="" title="Precio unitario" required class="input-p input-price">
        </td>
        <td class="p">
            <p class="total">$0.00 MX</p>
            <span class="total-discount"></span>
        </td>
    `;

    tbody.appendChild(newRow);

    // Añadir eventos a los nuevos inputs
    attachInputEvents(newRow);

    // Generar botón de eliminación solo si no es la fila base
    if (globalRowCounter > 1) {
        renderDeleteButton(globalRowCounter, xInitial, ((yInitial - 33) + (rowCount * 35)));
    }

    // Incrementar el contador global de filas
    globalRowCounter++;
}

function renderDeleteButton(rowId, x, y) {
    let button = document.createElement('button');
    button.classList.add('delete-row');
    button.id = `delete-row-${rowId}`;  // Asignar un ID único al botón de eliminar
    button.innerHTML = '<i class="fa-solid fa-trash"></i>';
    button.style.left = x + 'px';
    button.style.top = y + 'px';
    button.style.position = 'absolute'; // Posición absoluta para colocarlo correctamente

    // Evento para eliminar la fila correspondiente al hacer clic
    button.addEventListener('click', function () {
        deleteRow(rowId);
    });

    document.querySelector('#row-actions').appendChild(button);
}

function deleteRow(rowId) {
    // Evitar la eliminación de la fila 1 (inmutable)
    if (rowId === 1) {
        return;
    }

    // Eliminar la fila
    const row = document.getElementById(`row-${rowId}`);
    if (row) {
        row.remove();
    }

    // Eliminar el botón asociado
    const button = document.getElementById(`delete-row-${rowId}`);
    if (button) {
        button.remove();
    }

    // Actualizar los números de las filas restantes
    updateRowNumbers();
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('#table-body tr');
    rows.forEach((row, index) => {
        const counter = row.querySelector('.counter');
        counter.textContent = index + 1; // Actualizar el número de fila visible

        // Actualizar la posición de los botones de eliminar
        const rowId = row.id.split('-')[1]; // Extraemos el ID real de la fila (el número después de "row-")
        const button = document.getElementById(`delete-row-${rowId}`);
        if (button) {
            button.style.top = ((yInitial - 33) + ((index + 1) * 35)) + 'px'; // Actualizar la posición del botón
        }
    });
}

function attachInputEvents(row) {
    const productInput = row.querySelector('.input-product');
    const quantityInput = row.querySelector('.input-quantity');
    const priceInput = row.querySelector('.input-price');
    const totalField = row.querySelector('.total');
    const discountSpan = row.querySelector('.total-discount'); // Descuento en el total

    // Evento para mostrar sugerencias mientras se escribe en el campo de descripción
    productInput.addEventListener('input', function() {
        showSuggestions(productInput, row.querySelector('.suggestions'));
    });

    // Evento para cerrar sugerencias al presionar "Escape"
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeSuggestions(row.querySelector('.suggestions'));
        }
    });

    // Cerrar las sugerencias si el usuario hace clic fuera de ellas
    document.addEventListener('click', function(event) {
        if (!row.querySelector('.suggestions').contains(event.target) && !productInput.contains(event.target)) {
            closeSuggestions(row.querySelector('.suggestions'));
        }
    });

    // Actualizar el total al cambiar la cantidad o el precio
    quantityInput.addEventListener('input', function() {
        updateRowTotal(quantityInput, priceInput, totalField, discountSpan);
    });

    priceInput.addEventListener('input', function() {
        updateRowTotal(quantityInput, priceInput, totalField, discountSpan);
    });
}

function showSuggestions(input, suggestionsBox) {
    const searchTerm = input.value.toLowerCase();
    suggestionsBox.innerHTML = ''; // Limpiar contenido previo

    if (searchTerm.length > 0) {
        const filteredProducts = products.filter(product =>
            product.product.toLowerCase().includes(searchTerm)
        ).slice(0, 6); // Mostrar hasta 6 sugerencias

        filteredProducts.forEach(product => {
            const suggestionItem = document.createElement('div');
            suggestionItem.classList.add('suggestion-item');
            suggestionItem.textContent = product.product;
            suggestionItem.addEventListener('click', function() {
                selectProduct(input, product);
                closeSuggestions(suggestionsBox); // Cerrar sugerencias al seleccionar
            });
            suggestionsBox.appendChild(suggestionItem);
        });

        suggestionsBox.classList.remove('hidden');
        openSuggestions = suggestionsBox;
    } else {
        closeSuggestions(suggestionsBox);
    }
}

function closeSuggestions(suggestionsBox) {
    if (suggestionsBox) {
        suggestionsBox.classList.add('hidden');
        suggestionsBox.innerHTML = ''; // Limpiar sugerencias
        openSuggestions = null;
    }
}

function selectProduct(input, product) {
    const row = input.closest('tr');
    const counter = row.querySelector('.counter');
    const priceInput = row.querySelector('.input-price');
    const quantityInput = row.querySelector('.input-quantity');
    const totalField = row.querySelector('.total');
    const discountSpan = row.querySelector('.total-discount'); // El campo donde se muestra el descuento

    // Asignar el contador
    counter.textContent = row.querySelectorAll('.counter').length + 1;

    // Asignar los valores del producto seleccionado
    input.value = product.product;
    let originalPrice = parseFloat(product.price.replace(/[^0-9.-]+/g, ""));
    
    // Aplicar descuento si existe
    if (product.discount > 0) {
        const discountAmount = originalPrice * (product.discount / 100);
        const discountedPrice = originalPrice - discountAmount;
        priceInput.value = discountedPrice.toFixed(2); // Mostrar el precio con descuento
        discountSpan.textContent = `(${product.discount}% descuento)`; // Mostrar el porcentaje de descuento en el total
    } else {
        priceInput.value = originalPrice.toFixed(2); // No hay descuento, usar el precio normal
        discountSpan.textContent = ''; // Limpiar el texto de descuento si no aplica
    }

    quantityInput.max = product.stock || 1; // Si no hay stock, dejar el máximo en 1

    // Calcular el total inicial
    updateRowTotal(quantityInput, priceInput, totalField, discountSpan);
}

function updateRowTotal(quantityInput, priceInput, totalField, discountSpan) {
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(priceInput.value);

    if (!isNaN(quantity) && !isNaN(price)) {
        const total = quantity * price;
        totalField.textContent = formatCurrency(total) + ' MX'; // Formatear como moneda

        // Actualizar el total general
        updateFinalTotal();
    }
}

function updateFinalTotal() {
    let finalTotal = 0;
    const totalFields = document.querySelectorAll('.total');

    totalFields.forEach(totalField => {
        const totalText = totalField.textContent.replace(/[^0-9.-]+/g, "");
        finalTotal += parseFloat(totalText) || 0;
    });

    document.getElementById('final-total').textContent = formatCurrency(finalTotal) + ' MX'; // Formatear el total final
}

// Añadir eventos iniciales a la primera fila
attachInputEvents(document.querySelector('#row-1'));