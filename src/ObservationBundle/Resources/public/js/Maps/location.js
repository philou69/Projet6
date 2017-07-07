var coordinates = [],
    lastOpenInfoWindow,
    markerClusterer,
    markers = [];
function initMap() {

    // requete éffectué juste après le chargement de la page

    var map = new google.maps.Map(document.getElementById('mapLocation'),
        {
            center: {lat: 48.866667, lng: 2.333333},
            zoom: 5
        });
    $.ajax({
        url: $('#mapLocation').data('href'),
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // On verifie si n a recu un success ou non
            if (data.success) {
                // On boucle sur la quantité de result pour les ajouté dans le tableau coordonates
                for (var i = 0; i < data.result.length; i++) {
                    coordinates[i] = data.result[i];
                }
                markers = coordinates.map(function (coordinate, i) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: Number(coordinate.location.lat),
                            lng: Number(coordinate.location.lng)
                        },
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: '#99d1c8',
                            fillOpacity: 0.8,
                            strokeWeight: 1
                        }
                    });

                    var content = '<div class="container">' + '<div class="row">' + '<p>Observé vers : ' + coordinate.observation.lieu + '</p><p>Le : ' + coordinate.observation.seeAt + '</p><p>Nombre observé : </p>' + coordinate.observation.numbers + '</div></div>';

                    addInfoWindow(marker, content);
                    return marker;
                });

                markerClusterer = new MarkerClusterer(map, markers,{
                    imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                });

            }
            else
            {
                    $('#mapLocation').after('<p>L\'oiseau n\'a pas d\'observation</p>');
            }

        }
    });

// fonction ajoutant l'infowindow et la lie au marker
    function addInfoWindow(marker, content) {

        var infoWindow = new google.maps.InfoWindow({
            content: content
        });

        google.maps.event.addListener(marker, 'click', function () {
            // On vérifie si une autre windows est ouvert, dans ce cas on la ferme
            if (lastOpenInfoWindow != null) {
                lastOpenInfoWindow.close();
            }
            infoWindow.open(map, marker);
            lastOpenInfoWindow = infoWindow;
        });
        google.maps.event.addListener(marker, 'mouseover', function () {
            // On vérifie si une autre windows est ouvert, dans ce cas on la ferme
            if (lastOpenInfoWindow != null) {
                lastOpenInfoWindow.close();
            }
            infoWindow.open(map, marker);
            lastOpenInfoWindow = infoWindow;
        });

    }
}


