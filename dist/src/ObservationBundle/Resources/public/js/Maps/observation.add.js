'use strict';

//Initialisation de la map
function initMap() {
    var myLatlng = { lat: 48.866667, lng: 2.333333 };
    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatlng,
        zoom: 8
    }),
        marqueur = new google.maps.Marker(),
        geocoder = new google.maps.Geocoder(),
        infowindow = new google.maps.InfoWindow(),
        iconBaseOiseaux = '/bundles/observation/images/icones/crow_red.png';
    var lat_lng = void 0;

    /*
     Positionnement de la carte à l'affichage de la Map
     */
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            myLatlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(myLatlng);
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    /*
     Autocomplete du champ input/ récupération des infos
     */
    var input = document.getElementById('add_observation_location_lieu');
    var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function () {

        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat(),
            lng = place.geometry.location.lng();

        document.getElementById("add_observation_location_latitude").value = lat;
        document.getElementById("add_observation_location_longitude").value = lng;
    });

    //Création d'un marqueur sur la carte lors d'un clic. Remplissage automatique des champs Lat et Long
    google.maps.event.addListener(map, 'click', function (event) {
        lat_lng = { lat: event.latLng.lat(), lng: event.latLng.lng() };

        geocoder.geocode({ 'location': lat_lng }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    marqueur.setMap(map);
                    marqueur.setIcon(iconBaseOiseaux);
                    marqueur.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
                    map.setCenter(lat_lng);

                    document.getElementById("add_observation_location_latitude").value = event.latLng.lat();
                    document.getElementById("add_observation_location_longitude").value = event.latLng.lng();

                    var locationField = document.getElementById("add_observation_location_lieu");
                    locationField.value = results[0].address_components[2].long_name;

                    document.getElementById("infoPosition").textContent = locationField.value;
                    infowindow.setContent(results[0].address_components[2].long_name);
                    infowindow.open(map, marqueur);
                } else {
                    window.alert('Aucun résultat');
                }
            } else {
                window.alert('Géolocalisation échec: ' + status);
            }
        });
    });

    //Recupération des coordonées par geolocalisation du user

    document.getElementById("autoGeo").addEventListener("click", function () {

        // Géolocalisation du user.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                lat_lng = { lat: position.coords.latitude, lng: position.coords.longitude };

                geocoder.geocode({ 'location': lat_lng }, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {

                            marqueur.setMap(map);
                            marqueur.setPosition(lat_lng);
                            marqueur.setIcon(iconBaseOiseaux);
                            map.setCenter(lat_lng);
                            map.setZoom(14);

                            document.getElementById("add_observation_location_latitude").value = lat_lng.lat;
                            document.getElementById("add_observation_location_longitude").value = lat_lng.lng;
                            document.getElementById("add_observation_location_lieu").value = results[0].address_components[2].long_name;

                            infowindow.setContent(results[0].address_components[2].long_name);
                            infowindow.open(map, marqueur);
                        } else {
                            window.alert('Aucun résultat');
                        }
                    } else {
                        window.alert('Géolocalisation échec: ' + status);
                    }
                });
            },
            //gestion des erreurs de geolocalisation
            function () {
                handleLocationError(true, marker, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, marker, map.getCenter());
        }

        //Gestion des erreurs de géolocalisation
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
        }
    });
}

//Affihage de la fenêtre modale de la map
document.getElementById("locationChoice").addEventListener('click', function () {
    $('#myModal').modal('show').on('shown.bs.modal', function () {
        initMap();
    });
});
//# sourceMappingURL=observation.add.js.map