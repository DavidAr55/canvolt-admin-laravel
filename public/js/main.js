function redirectTo(url) {
    location.href = url;
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    // Evento para detectar cambios en el input
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();
        if (query.length > 0) {
            fetchProducts(query);
        } else {
            closeSearchResults(); // Cerrar si el input está vacío
        }
    });

    // Evento para detectar tecla "Escape" y cerrar resultados
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeSearchResults();
        }
    });

    // Evento para detectar clics fuera del input o del contenedor de resultados
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            closeSearchResults();
        }
    });

    const productApi = document.querySelector('meta[name="product-api"]').getAttribute('content');

    function fetchProducts(query) {
        fetch(productApi)
            .then(response => response.json())
            .then(data => {
                const filteredProducts = data.filter(product =>
                    product.product.toLowerCase().includes(query)
                );
                displayResults(filteredProducts, query);
            })
            .catch(error => {
                console.error('Error al obtener los productos:', error);
            });
    }

    function displayResults(products, query) {
        searchResults.innerHTML = ''; // Limpiar resultados previos
    
        if (products.length > 0) {
            searchResults.classList.remove('d-none'); // Mostrar los resultados
            products.forEach(product => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
    
                // Hacer el contenedor clickeable
                listItem.addEventListener('click', function () {
                    // Redirigir en otra pestaña
                    window.open(`http://127.0.0.1:8000/productos/todos/${product.product}`);
                });
    
                // Mostrar la información del producto
                listItem.innerHTML = `
                    <strong>${product.product}</strong><br>
                    <small>${product.description_min}</small><br>
                    <span>Precio: ${product.price}</span>
                `;
                searchResults.appendChild(listItem);
            });
        } else {
            // Mostrar el mensaje de "no se encontró ningún resultado"
            const noResultsItem = document.createElement('li');
            noResultsItem.classList.add('list-group-item', 'text-muted');
            noResultsItem.innerHTML = `No se encontró ningún resultado para "${query}"`;
    
            searchResults.appendChild(noResultsItem);
            searchResults.classList.remove('d-none'); // Mostrar la caja de resultados
        }

        if (query.length === 0) {
            closeSearchResults();
        }
    }    

    // Función para cerrar los resultados
    function closeSearchResults() {
        searchResults.innerHTML = '';
        searchResults.classList.add('d-none'); // Ocultar los resultados
    }
});
