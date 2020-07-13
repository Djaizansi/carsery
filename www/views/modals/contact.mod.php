<?php

use carsery\core\Helpers;
use carsery\Managers\ContactManager;

$contactManager = new ContactManager();
$listContact = $contactManager->findAll();

?>
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      div[id^=googlemap], 
        div[id^=googlemap] div {overflow: auto;}
      #googlemap {
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
<form>
    <h1>Me contacter (AFFICHAGE FRONT)</h1>
    <label for="magasin-select">Choisissez un magasin :</label>
    <select name="magasin" id="magasin-select">
    <?php foreach($listContact as $unContact): ?>
    <option value="<?= $unContact->getId() ?>"><?= $unContact->getNom() ?> (<?= $unContact->getAdresse() ?>)</option>
    <?php endforeach ?>
    </select>
    <div id="googlemap"></div>
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
    </div>
<script>
function initMap() {
  var map = new google.maps.Map(document.getElementById('googlemap'), {
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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVds3bkBGSlDIfcPvpwza_8mdjK54y75o&callback=initMap">
</script>