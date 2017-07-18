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
            let content = '<div class="container">' +
                            '<div class="row">' +
                            '<h5>Observation</h5>' +
                                '<div class="col-xs-12">' +
                                    '<p><strong>Observé vers: </strong> ' + coordinate.observation.lieu + '</p>' +
                                    '<p><strong>Le: </strong> ' + coordinate.observation.seeAt + '</p>' +
                                     '<p><strong>Nombre observé: </strong>' + coordinate.observation.numbers + '</p>' +
                                 '</div>' +
                            '</div>' +
                        '</div>';

            addInfoWindow(circle, content);

            return circle;
    })
}

// fonction ajoutant l'infowindow et la lie au marker
    function addInfoWindow(circ, content) {

        let infoWindow = new google.maps.InfoWindow({
            content: content
        });

        //Event sur le hover marker
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

        //customization infowindows
        google.maps.event.addListener(infoWindow, 'domready', function() {

            // Reference to the DIV which receives the contents of the infowindow using jQuery
            let iwOuter = $('.gm-style-iw');

            /* The DIV we want to change is above the .gm-style-iw DIV.
             * So, we use jQuery and create a iwBackground variable,
             * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
             */
            let iwBackground = iwOuter.prev();

            // Remove the background shadow DIV
            iwBackground.children(':nth-child(2)').css({'display' : 'none'});

            // Remove the white background DIV
            iwBackground.children(':nth-child(4)').css({'display' : 'none'});

            // Changes the desired color for the tail outline.
// The outline of the tail is composed of two descendants of div which contains the tail.
// The .find('div').children() method refers to all the div which are direct descendants of the previous div.
            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

            let iwCloseBtn = iwOuter.next();

// Apply the desired effect to the close button
            iwCloseBtn.css({
                opacity: '1', // by default the close button has an opacity of 0.7
                right: '45px', top: '9px', // button repositioning
                border: '4px solid #99d1c8', // increasing button border and new color
                'border-radius': '20px', // circular effect
                'box-shadow': '0 0 5px #99d1c8', // 3D effect to highlight the button
                width: '20px',
                height: '20px'
            });

// The API automatically applies 0.7 opacity to the button after the mouseout event.
// This function reverses this event to the desired value.
            iwCloseBtn.mouseout(function(){
                $(this).css({opacity: '1'});
            });

        });

    }


}


