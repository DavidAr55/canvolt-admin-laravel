(function ($) {
  const basedUrl = $('meta[name="based-url"]').attr('content');
  const branchName = $('meta[name="branch-name"]').attr('content');
  const csrfToken = $('meta[name="csrf-token"]').attr('content');

  'use strict';
  $.fn.andSelf = function () {
    return this.addBack.apply(this, arguments);
  }
  $(function () {

    // Get the total price of services using fetch
    fetch('/api/v1/dashboard-data/services')
      .then(response => response.json())
      .then(data => {
        // Update the services container with the total price
        $('#services-container').html(`
          <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h3 class="mb-0">${data.total_price}</h3>
              ${data.percentage}
          </div>
          <h6 class="text-muted font-weight-normal">${data.message}</h6>
        `)
      })

    // Get the total price of products using fetch
    fetch('/api/v1/dashboard-data/products')
      .then(response => response.json())
      .then(data => {
        // Update the services container with the total price
        $('#products-container').html(`
          <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h3 class="mb-0">${data.total_price}</h3>
              ${data.percentage}
          </div>
          <h6 class="text-muted font-weight-normal">${data.message}</h6>
        `)
      })

    // Get the total price of purchases using fetch
    fetch('/api/v1/dashboard-data/purchases')
      .then(response => response.json())
      .then(data => {
        // Update the services container with the total price
        $('#purchases-container').html(`
          <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h3 class="mb-0">${data.total_price}</h3>
              ${data.percentage}
          </div>
          <h6 class="text-muted font-weight-normal">${data.message}</h6>
        `)
      })

    //check all boxes in order status 
    $("#check-all").click(function () {
      $(".form-check-input").prop('checked', $(this).prop('checked'));
    });

    // Verifica si el elemento de la gráfica está presente en el DOM
    if ($("#transaction-history").length) {
      fetch('/api/v1/dashboard-data/month-transactions') // Llamada a la API para obtener los datos de transacciones
        .then(response => response.json())
        .then(data => {
          // Actualiza los valores en el DOM
          document.querySelector('.custom-value').innerHTML = `${data.total} <span>Total</span>`;
          document.querySelector('.service-transaction-total').innerHTML = `${data.services_total}`;
          document.querySelector('.product-transaction-total').innerHTML = `${data.products_total}`;

          // Inicializa la gráfica de doughnut con los datos recibidos
          const doughnutChartCanvas = document.getElementById('transaction-history');
          new Chart(doughnutChartCanvas, {
            type: 'doughnut',
            data: {
              labels: ["Servicios", "Productos"],
              datasets: [{
                data: [data.services_percentage, data.products_percentage], // Datos dinámicos de servicios y productos
                backgroundColor: ["#FF8300", "#00d25b"], // Colores para los servicios y productos
                borderColor: "#191c24"
              }]
            },
            options: {
              cutout: 70,
              animationEasing: "easeOutBounce",
              animateRotate: true,
              animateScale: false,
              responsive: true,
              maintainAspectRatio: true,
              showScale: false,
              legend: false,
              plugins: {
                legend: {
                  display: false,
                },
              },
            },
          });
        })
        .catch(error => console.error('Error al obtener los datos de transacciones:', error));
    }

    if ($('#service-and-product-sales').length) {
      fetch('/api/v1/dashboard-data/service-and-product-sales')
        .then(response => response.json())
        .then(data => {
          console.log(data);
          
          // Seleccionar el cuerpo de la tabla
          const tableBody = $('#service-and-product-sales tbody');
          
          // Limpiar cualquier contenido existente en el cuerpo de la tabla
          tableBody.empty();
    
          // Iterar sobre los datos recibidos de la API y crear las filas
          data.data.forEach(item => {
            const ticket = item.ticket;
    
            // Convertir el tipo de ticket de array a una cadena legible (opcional)
            const ticketType = JSON.parse(ticket.type).join(', ');
    
            // Formatear la fila de la tabla
            const row = `
              <tr>
                <td>
                  <span class="ps-2">${item.user}</span>
                </td>
                <td>${ticket.folio}</td>
                <td>${ticket.total_price}</td>
                <td>${ticketType}</td>
                <td>${ticket.payment_method}</td>
                <td>${ticket.country_code}</td>
                <td>${new Date(ticket.updated_at).toLocaleDateString()}</td>
                <td>
                  <button class="badge bg-transparent ${ticket.class}">
                    ${ticket.status.charAt(0).toUpperCase() + ticket.status.slice(1)}
                  </button>
                </td>
              </tr>
            `;
    
            // Insertar la nueva fila en la tabla
            tableBody.append(row);
          });
        })
        .catch(error => console.error('Error al obtener las ventas de servicios y productos: ', error));
    }    

    if ($('#owl-carousel-basic').length) {
      console.log('branchName: ' + branchName);
      
      // Enviar el nombre de la sucursal al servidor para obtener la galería
      fetch('/api/v1/dashboard-data/gallery', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          branch_name: branchName
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
    
        // Suponemos que solo hay un resultado en el array de 'gallery'
        const photos = JSON.parse(data.gallery[0].photos); // Decodificar el array de fotos
        
        // Agregar las imágenes al carrusel
        photos.forEach(photo => {
          $('#owl-carousel-basic').append(`
            <div class="item">
              <img src="${basedUrl}/storage/${photo}" alt="Branch Gallery Image">
            </div>
          `);
        });
    
        // Inicializar el carrusel con configuraciones dinámicas
        $('#owl-carousel-basic').owlCarousel({
          loop: true,
          margin: 10,
          dots: false,
          nav: true,
          autoplay: true,
          autoplayTimeout: 4500,
          navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
          // Mostrar 5 imágenes en pantallas grandes
          responsive: {
            0: {
              items: 1
            },
            250: {
              items: 1
            },
            500: {
              items: 1
            },
            750: {
              items: 1
            },
            1000: {
              items: 1
            }
          }
        });
      })
      .catch(error => console.error('Error fetching gallery:', error));
    }      
    if ($('#audience-map').length) {
      $('#audience-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        panOnDrag: true,
        focusOn: {
          x: -30.00,
          y: 0.50,
          scale: 2,
          animate: true
        },
        series: {
          regions: [{
            scale: ['#3d3c3c'],
            normalizeFunction: 'polynomial',
            values: {
              "MX": 10.00,
            }
          }]
        }
      });
    }
  });
})(jQuery);
