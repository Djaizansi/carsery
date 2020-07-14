<?php

use carsery\core\Helpers;
use carsery\Managers\ContactManager;

$contactManager = new ContactManager();
$listContact = $contactManager->findAll();

?>
<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    div[id^=map],
    div[id^=map] div {
        width:800px;
        height:800px;
    }
</style>
<div class="container">
    <form>
        <span id=submit class="floating-panel"></span>
        <h1>Nous contacter</h1>
        <label for="magasin-select">Choisissez un magasin :</label>
        <select name="magasin" id="magasin-select" onchange="initMap()">
            <?php foreach ($listContact as $unContact) : ?>
                <option value="<?= $unContact->getAdresse() ?>"><?= $unContact->getAdresse() ?></option>
            <?php endforeach ?>
        </select>
        <div id="map"></div>
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
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 11,
            center: {
                lat: 40.731,
                lng: -73.997
            }
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        address = document.getElementById("magasin-select").value; // on récupère l'adresse sélectionné 
        // var latlngStr = address.split(',', 2);
        // var latlng = {
        //     lat: parseFloat(latlngStr[0]),
        //     lng: parseFloat(latlngStr[1])
        // };

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setZoom(16);
                    var latlng = results[0].geometry.location
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map
                    });
                    map.setCenter(marker.getPosition())
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }
    function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {
            lat: parseFloat(latlngStr[0]),
            lng: parseFloat(latlngStr[1])
        };
        geocoder.geocode({
            'location': latlng
        }, function(results, status) {
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap">
</script>