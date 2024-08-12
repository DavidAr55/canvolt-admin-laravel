(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
})(jQuery);

$(document).ready(function() {
  $('.js-example-basic-multiple').select2({
      maximumSelectionLength: 4,
      language: {
          maximumSelected: function (e) {
              var message = "¡El carrusel solo puede mostrar hasta " + e.maximum + " productos!";
              return message;
          }
      }
  });
});