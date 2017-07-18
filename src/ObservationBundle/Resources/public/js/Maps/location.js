let coordinates = [],
    lastOpenInfoWindow,
    markerClusterer,
    markers = [];
function initMap() {

    // requete éffectué juste après le chargement de la page

    let map = new google.maps.Map(document.getElementById('mapLocation'),
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
            if (data.success)
            {
                addMarkers(data)
            }
            else
            {
                $('#mapLocation').after('<p>L\'oiseau n\'a pas d\'observation</p>');
            }

        }
    });

    //Fonction ajoutant des markers
    function addMarkers(data) {
        // On boucle sur la quantité de result pour les ajouté dans le tableau coordonates
        for (let i = 0; i < data.result.length; i++) {
            coordinates[i] = data.result[i];
        }
        //On definit les markers
        markers = coordinates.map(function (coordinate, i) {

            let circle = new google.maps.Circle({
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#99d1c8',
                fillOpacity: 0.5,
                map: map,
                center: {lat: Number(coordinate.location.lat),
                    lng: Number(coordinate.location.lng)
                },
                radius: 20000
            });

            //defintion du content infoWindow
            let content = '<div class="container">' + '<div class="row">' + '<p><strong>Observé vers: </strong> ' + coordinate.observation.lieu + '</p><p><strong>Le: </strong> ' + coordinate.observation.seeAt + '</p><p><strong>Nombre observé: </strong>' + coordinate.observation.numbers + '</p></div></div>';

            addInfoWindow(circle, content);

            return circle;
    })
}

// fonction ajoutant l'infowindow et la lie au marker
    function addInfoWindow(circ, content) {

        let infoWindow = new google.maps.InfoWindow({
            content: content
        });

        google.maps.event.addListener(circ, 'click', function (ev) {
            // On vérifie si une autre windows est ouvert, dans ce cas on la ferme
            if (lastOpenInfoWindow != null)
            {
                lastOpenInfoWindow.close();
            }
            infoWindow.setPosition(ev.latLng);
            infoWindow.open(map);
            lastOpenInfoWindow = infoWindow;
        });
        google.maps.event.addListener(circ, 'mouseover', function (ev) {
            // On vérifie si une autre windows est ouvert, dans ce cas on la ferme
            if (lastOpenInfoWindow != null)
            {
                lastOpenInfoWindow.close();
            }
            infoWindow.setPosition(ev.latLng);
            infoWindow.open(map);
            lastOpenInfoWindow = infoWindow;
        });

    }
}


