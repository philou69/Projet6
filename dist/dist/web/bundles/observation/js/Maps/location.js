'use strict';

$(document).ready(function () {

    function initMap() {

        // requete éffectué juste après le chargement de la page

        var map = new google.maps.Map(document.getElementById('mapLocation'), {
            center: {lat: 48.866667, lng: 2.333333},
            zoom: 5
        });

        var coordinates = [],
            markerstable = [],
            infoWindow = new google.maps.InfoWindow(),
            lat_lng = void 0;

        $.ajax({
            url: $('#mapLocation').data('href'),
            method: 'get',
            dataType: 'json',
            success: function success(data) {
                console.log(data);
                data.forEach(function (datas) {
                    if (datas.latitude !== null && datas.longitude !== null) {
                        coordinates.push(datas);
                    }
                });
                coordinates.forEach(function (data) {
                    console.log(data.observations[0].observation);

                    var marqueur = new google.maps.Marker({
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 12,
                            fillColor: '#99d1c8',
                            fillOpacity: 0.8,
                            strokeWeight: 1
                        }
                    });

                    var content = '<div class="container">' + '<div class="row">' + '<p>Observé vers : ' + data.lieu + '</p><p>Le : ' + data.observations[0].seeAt.date + '</p><p>Commentaire: </p>' + data.observations[0].observation + '</div></div>';
                    infoWindow.setContent(content);

                    lat_lng = {
                        lat: data.latitude,
                        lng: data.longitude
                    };

                    marqueur.setMap(map);
                    marqueur.setPosition(lat_lng);

                    marqueur.addListener('click', function () {
                        infoWindow.open(map, marqueur);
                    });
                });
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initMap());
});
//# sourceMappingURL=location.js.map
//# sourceMappingURL=location.js.map