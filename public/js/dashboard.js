(function ($) {
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
              <h2 class="mb-0">${data.total_price}</h2>
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
              <h2 class="mb-0">${data.total_price}</h2>
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

    if ($('#owl-carousel-basic').length) {
      $('#owl-carousel-basic').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4500,
        navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 1
          },
          1000: {
            items: 1
          }
        }
      });
    }
    if ($('#audience-map').length) {
      $('#audience-map').vectorMap({
        map: 'world_mill_en',
        backgroundColor: 'transparent',
        panOnDrag: true,
        focusOn: {
          x: 0.5,
          y: 0.5,
          scale: 1,
          animate: true
        },
        series: {
          regions: [{
            scale: ['#3d3c3c', '#f2f2f2'],
            normalizeFunction: 'polynomial',
            values: {

              "MX": 10.00,
              "US": 90.00
            }
          }]
        }
      });
    }
    if ($('#owl-carousel-rtl').length) {
      $('#owl-carousel-rtl').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        rtl: isrtl,
        autoplay: true,
        autoplayTimeout: 4500,
        navText: ["<i class='mdi mdi-chevron-right'></i>", "<i class='mdi mdi-chevron-left'></i>"],
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 1
          },
          1000: {
            items: 1
          }
        }
      });
    }
    if ($("#currentBalanceCircle").length) {
      var bar = new ProgressBar.Circle(currentBalanceCircle, {
        color: '#ccc',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 12,
        trailWidth: 12,
        trailColor: '#0d0d0d',
        easing: 'easeInOut',
        duration: 1400,
        text: {
          autoStyleContainer: false,
        },
        from: { color: '#d53f3a', width: 12 },
        to: { color: '#d53f3a', width: 12 },
        // Set default step function for all animate calls
        step: function (state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);

          var value = Math.round(circle.value() * 100);
          circle.setText('');

        }
      });

      bar.text.style.fontSize = '1.5rem';

      bar.animate(0.4);  // Number from 0.0 to 1.0
    }
  });
})(jQuery);
