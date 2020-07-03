<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        width: 100%;
        position: relative;
        display: always;
      }
      /* Optional: Makes the sample page fill the window. */
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        width: 350px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
      #latlng {
        width: 225px;
      }
    </style>
<div class="container">
<form action="" method="post" id="contact">
    <h1>Me contacter (AFFICHAGE FRONT)</h1>
    <fieldset>
        <input placeholder="Votre nom" type="text" tabindex="1" required autofocus>
    </fieldset>
    <fieldset>
        <input placeholder="Votre adresse mail" type="email" tabindex="2" required>
    </fieldset>
    <fieldset>
        <input placeholder="Votre numéro de téléphone" type="tel" tabindex="3" required>
    </fieldset>
    <fieldset>
        <textarea placeholder="Entrez votre message ici..." tabindex="4" required></textarea>
    </fieldset>
    <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Envoyez !</button>
</form>
<div id="floating-panel">
      <input id="latlng" type="text" value="40.714224,-73.961452">
      <input id="submit" type="button" value="Reverse Geocode">
</div>
<div id="map"></div>
<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.992869011805!2d2.254747315917278!3d48.839274710006144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67abe47ddbbc3%3A0xb25f2fa00320ce57!2sAUDI%20Paris%2016%20-%20Premium%20Automobiles!5e0!3m2!1sfr!2sfr!4v1591528469366!5m2!1sfr!2sfr" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
</div>
<script>
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: {lat: 40.731, lng: -73.997}
  });
  var geocoder = new google.maps.Geocoder;
  var infowindow = new google.maps.InfoWindow;

  document.getElementById('submit').addEventListener('click', function() {
    geocodeLatLng(geocoder, map, infowindow);
  });
}

function geocodeLatLng(geocoder, map, infowindow) {
  var input = document.getElementById('latlng').value;
  var latlngStr = input.split(',', 2);
  var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[0]) {
        map.setZoom(11);
        var marker = new google.maps.Marker({
          position: latlng,
          map: map
        });
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
      } else {
        window.alert('No results found');
      }
    } else {
      window.alert('Geocoder failed due to: ' + status);
    }
  });
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGHlyjkB4wVVYENmf3cUNCskgSSjMOC2k&callback=initMap">
    </script>
