document.addEventListener('DOMContentLoaded', function() {
    let countriesApi = document.head.querySelector('meta[name="countries-api"]').content;

    console.log("API: " + countriesApi);
    // Consumir la API con el encavezado "Access-Control-Allow-Origin: *"
    fetch(countriesApi, {
        headers: {
            'Access-Control-Allow-Origin': '*'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countrySelect = document.getElementById('country_code');
            const countries = data.countries;

            console.log(countries);

            // Limpiar las opciones actuales del select
            countrySelect.innerHTML = '';

            // Añadir las opciones al select
            for (const [code, name] of Object.entries(countries)) {
                const option = document.createElement('option');
                option.value = code;
                option.textContent = name;
                countrySelect.appendChild(option);
                if (code === 'MX') {
                    option.selected = true;
                }
            }
        } else {
            console.error("Error al obtener la lista de países");
        }
    })
    .catch(error => console.error('Error al consumir la API:', error));
});
