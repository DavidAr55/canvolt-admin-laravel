// Función para arrastrar el formulario flotante
let form = document.getElementById("floatingForm");
let formHeader = document.querySelector(".form-header");
let isDragging = false;
let offsetX = 0;
let offsetY = 0;

formHeader.addEventListener("mousedown", function (e) {
    isDragging = true;
    offsetX = e.clientX - form.getBoundingClientRect().left;
    offsetY = e.clientY - form.getBoundingClientRect().top;
});

document.addEventListener("mousemove", function (e) {
    if (isDragging) {
        form.style.left = e.clientX - offsetX + "px";
        form.style.top = e.clientY - offsetY + "px";
    }
});

document.addEventListener("mouseup", function () {
    isDragging = false;
});

// Minimizar y maximizar el formulario
function minimizeForm() {
    document.getElementById("floatingForm").style.display = "none";
    document.getElementById("minimizedForm").style.display = "block";
}

function maximizeForm() {
    document.getElementById("floatingForm").style.display = "block";
    document.getElementById("minimizedForm").style.display = "none";
}

document.addEventListener('DOMContentLoaded', function () {
    let saleType = document.getElementById('sale_type');
    let ticketOptions = document.querySelectorAll('input[name="ticket"]');
    saleType.value = '[\n\t"product"\n]';

    ticketOptions.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'venta') {
                saleType.value = '[\n\t"product"\n]';
                
                let products = document.querySelectorAll('input[name="product[]"]');
                let hasProducts = false;
                let hasServices = false;

                products.forEach(function (product) {
                    if (product.dataset.type === 'product') {
                        hasProducts = true;
                    } else if (product.dataset.type === 'service') {
                        hasServices = true;
                    }
                });

                if (hasProducts && hasServices) {
                    saleType.value = '[\n\t"product",\n\t"service"\n]';
                } else if (hasProducts) {
                    saleType.value = '[\n\t"product"\n]';
                } else if (hasServices) {
                    saleType.value = '[\n\t"service"\n]';
                }
            } else if (this.value === 'cotizacion') {
                saleType.value = '[\n\t"quotation"\n]';
            }
        });
    });
});

