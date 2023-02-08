document.addEventListener("DOMContentLoaded", function() {
  inicializarMapa();
});

function inicializarMapa() {
    var input = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(input);
  };