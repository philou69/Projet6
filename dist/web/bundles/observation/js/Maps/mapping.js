'use strict';

var locations = [];
var lastOpenInfoWindow;
var markers = [];
var markerClusterer;
// fonction appelant la carte maps et ajoutant les markers
function initMap() {
    // Appelle de la map
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {lat: 46.2276, lng: 2.2137}
    });
    // Requete ajax pour récuperer la liste des localisation des oiseaux
    $.ajax({
        url: '/bird/paging-all',
        type: 'GET',
        success: function success(data) {
            // la requete est un success
            // on vérifie si data.success est true
            if (data.success) {
                addMarkers(data);
            } else {
                // Il n'y a pas d'oiseaux à localiser
                $('#filter').append('<p id="status">Aucuns oiseaux  observer</p>');
            }
            $('#filters').removeAttr('disabled');
        }
    });
    $("#filters").on('change', function (event) {
        // On vide la carte de tous markers pour repartir a 0
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
            markers[i] = null;
        }
        locations = [];
        markers = [];
        // On retire tout texte précedent de filter
        $('#status').remove();
        $.ajax({
            url: '/bird/paging-all?bird=' + $(this).val(),
            type: 'GET',
            success: function success(data) {

                // on vérifie si data.success est true
                if (data.success) {
                    addMarkers(data);
                } else {
                    // Sinon aucune observation pour l'espece
                    $('#filter').append('<p id="status">Aucune observation pour l\'espece séléctionne</p>');
                }
            }
        });
    });
    function addMarkers(data) {
        for (var i = 0; i < data.result.length; i++) {
            // On ajoute chaque entrées au tableau locations
            locations[i] = data.result[i];
        }
        // ajout des marqueurs sur la carte
        markers = locations.map(function (location, i) {
            // Création d'un marqueur sur la position de location
            var marker = new google.maps.Marker({
                position: {lat: Number(location[0].lat), lng: Number(location[0].lng)},
                // Affichage d'un cercle au couleur de NAO
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 12,
                    fillColor: '#99d1c8',
                    fillOpacity: 0.8,
                    strokeWeight: 1
                }
            });

            // contenu html de l'infowindow en fonction du contenu de location
            var content = '<div class="container"><div class="row"><div class="col-xs-4">' + location[1].image + '</div><div class="col-xs-8"><h5>' + location[1].name + '</h5><p>' + location[1].description + '</p><a href="' + location[1].ficheUrl + '">Fiche oiseau</a> <a href="' + location[1].addUrl + '">Ajouter observation</a></div></div></div></div>';
            addInfoWindow(marker, content);
            return marker;
        });

        // création d'un clusterer pour les groupes de markers
        markerClusterer = new MarkerClusterer(map, markers, {
            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });
    }
}

// fonction ajoutant l'infowindow et la lie au marker
function addInfoWindow(marker, content) {

    var infoWindow = new google.maps.InfoWindow({
        content: content
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
//# sourceMappingURL=mapping.js.map