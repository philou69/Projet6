//Initilaisation de la map
function initMap()
{

    var myLatlng = {lat: 48.866667, lng: 2.333333};
    var map = new google.maps.Map(document.getElementById('map'),
        {
            center: myLatlng,
            zoom: 12
        });


    // Géolocalisation du user.
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(function(position)
            {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                //Personnalisation du marker de position actuelle
                var iconBase = 'https://maps.google.com/mapfiles/kml/paddle/orange-stars.png';

                //Création du marker
                var marker = new google.maps.Marker(
                    {
                        position: pos,
                        map: map,
                        zoom: 12,
                        icon: iconBase
                    });

                map.setCenter(pos);
            },
            //gestion des erreurs de geolocalisation
            function() {
                handleLocationError(true, marker, map.getCenter());
            });
    }
    else
    {
        // Browser doesn't support Geolocation
        handleLocationError(false, marker, map.getCenter());
    }

    //Création d'un marqueur sur la carte lors d'un clic. Remplissage automatique des champs Lat et Long
    var marqueur = new google.maps.Marker();
    google.maps.event.addListener(map, 'click', function (event)
    {
        marqueur.setMap(map);
        marqueur.setIcon(iconBaseOiseaux);
        var positionMarqueur = marqueur.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
        document.getElementById("add_observation_location_latitude").placeholder = event.latLng.lat();
        document.getElementById("add_observation_location_longitude").placeholder = event.latLng.lng();
    });
}

//Gestion des erreurs de géolocalisation
function handleLocationError(browserHasGeolocation, infoWindow, pos)
{
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}
