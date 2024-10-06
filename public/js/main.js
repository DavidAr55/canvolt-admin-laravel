function redirectTo(url) {
    location.href = url;
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();
        if (query.length > 0) {
            fetchProducts(query);
        } else {
            searchResults.innerHTML = '';
        }
    });

    function fetchProducts(query) {
        fetch('http://127.0.0.1:8000/api/v1/products-get-data')
            .then(response => response.json())
            .then(data => {
                const filteredProducts = data.filter(product =>
                    product.product.toLowerCase().includes(query)
                );
                displayResults(filteredProducts);
            })
            .catch(error => {
                console.error('Error al obtener los productos:', error);
            });
    }

    function displayResults(products) {
        searchResults.innerHTML = '';
        if (products.length > 0) {
            products.forEach(product => {
                searchResults.classList.remove('d-none');

                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                
                // Hacer el contenedor clickeable
                listItem.addEventListener('click', function () {
                    window.location.href = `/product/${product.product}`;
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
            // searchResults.innerHTML = '<li class="list-group-item">No se encontraron productos.</li>';
            searchResults.classList.add('d-none');
        }
    }
});
