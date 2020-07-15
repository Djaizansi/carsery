<?php

use carsery\core\Helpers;
use carsery\Managers\ContactManager;

$contactManager = new ContactManager();
$listContact = $contactManager->findAll();

?>
<style>
    /* Toujours définir la hauteur de la map pour l'élément qui contient la map */
    div[id^=map],
    div[id^=map] div {
        height: 800px;
    }

    .selectmel {
        display: block;
        width: 100%;
        height: 40px;
        padding: 6px 12px;
        font-size: 15px;
        line-height: 1.5;
        color: #6c6c6c;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ddd;
        border-radius: 0;
        box-shadow: none;
    }
</style>
<div class="container">
    <form action="" method="post" id="contact">
        <span id=submit class="floating-panel"></span>
        <h1>Nous contacter</h1>
        <h3>Choisissez un magasin : </h2>
        <fieldset>
            <select name="magasin" id="magasin-select" class="selectmel" onchange="initMap()">
                <?php foreach ($listContact as $unContact) : ?>
                    <option value="<?= $unContact->getAdresse() ?>"><?= $unContact->getNom() ?>(<?= $unContact->getAdresse() ?>)</option>
                <?php endforeach ?>
            </select>
        </fieldset>
            <div class="container">
                <div id="map"></div>
            </div>
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
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        address = document.getElementById("magasin-select").value; // on récupère l'adresse sélectionné 

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var latlng = results[0].geometry.location
                    var lat = results[0].geometry.location.lat
                    var lng = results[0].geometry.location.lng
                    var map = new google.maps.Map(document.getElementById('map'));
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map
                    });
                    map.setCenter(marker.getPosition())
                    map.setZoom(16);
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
                    window.alert('Aucun résultat trouvé avec cette adresse, merci de prévénir les administrateurs du site');
                }
            } else {
                window.alert('Erreur geocoder code : ' + status);
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4GSNes5jn7bQZHCBzwEiQjDAlzgII568&callback=initMap">
</script>