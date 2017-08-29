let locations = [],
    lastOpenInfoWindow,
    markers = [],
    markerClusterer;
// fonction appelant la carte maps et ajoutant les markers
function initMap() {

    //Selecteur avec champ de saisie
    $('#filters').select2().hide;

    // Appelle de la map
    let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {lat: 46.2276, lng: 2.2137}
    });
    // Requete ajax pour récuperer la liste des localisation des oiseaux
    $.ajax({
        url: $('#map').data('href'),
        type: 'GET',
        success: function (data) {
            // la requete est un success
            // on vérifie si data.success est true
            if (data.success)
            {
                addMarkers(data)
            }
            else
            {
                // Il n'y a pas d'oiseaux à localiser
                $('#filter').append('<p id="status">Aucun oiseaux observés</p>');
            }
            $('#filter').removeAttr('hidden');
        }
    });

    //Lors de la selection d'un oiseau
    $("#filters").on('change', function (event) {
        // On vide la carte de tous markers pour repartir a 0
        for (let i = 0; i < markers.length; i++)
        {
            markers[i].setMap(null);
            markers[i] = null
        }
        locations = [];
        markers = [];
        // On retire tout texte précedent de filter
        $('#status').remove();
        //requête adaptée
        $.ajax({
            url: $('#map').data('href')+ '?bird=' + $(this).val(),
            type: 'GET',
            success: function (data) {

                // on vérifie si data.success est true
                if (data.success)
                {
                    addMarkers(data)
                }
                else
                {
                    // Sinon aucune observation pour l'espece
                    $('#filter').append('<p id="status">Aucune observation pour l\'espèce sélectionnée</p>')
                }
            }
        });
    })

    //fonction ajoutant des markers
    function addMarkers(data){
        for (let i = 0; i < data.result.length; i++) {
            // On ajoute chaque entrées au tableau locations
            locations[i] = data.result[i];
        }
        // ajout des marqueurs sur la carte
        markers = locations.map(function (location, i) {
            // Création d'un marqueur sur la position de location
            let circle = new google.maps.Circle({
                strokeColor: '#000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#99d1c8',
                fillOpacity: 0.5,
                map: map,
                center:  {lat: Number(location[0].lat), lng: Number(location[0].lng)},
                radius: 20000
            });

            // contenu html de l'infowindow en fonction du contenu de location
            let content = '<div class="container">' +
                                '<div class="row">' +
                                '<h5>' + location[1].name + '</h5>' +
                                    '<div class="col-xs-4">' + location[1].image + '</div>' +
                                    '<div class="col-xs-8">' +
                                        // '<h5><strong>' + location[1].name + '</h5></strong>' +
                                        '<p id="desc">' + location[1].description + '... ' +
                                            '<a href="' + location[1].ficheUrl + '">Fiche oiseau</a>' +
                                        '</p>' +
                                        '<p>' +
                                            '<a href="' + location[1].addUrl + '">Ajouter observation</a>' +
                                        '</p>' +
                                    '</div>' +
                                 '</div>' +
                                '</div>' +
                            '</div>';

            addInfoWindow(circle, content);


            return circle;
        });

    }


// fonction ajoutant l'infowindow et la lie au marker
    function addInfoWindow(circle, content) {

        let infoWindow = new google.maps.InfoWindow({
            content: content
        });

        //Event sur le hover marker
        google.maps.event.addListener(circle, 'mouseover', function (ev) {
            // On vérifie si une autre windows est ouvert, dans ce cas on la ferme
            if (lastOpenInfoWindow != null) {
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

            // Moves the infowindow 115px to the right.
            iwOuter.parent().parent().css({left: '115px'});

            // Moves the shadow of the arrow 76px to the left margin
            iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 155px !important;'});

// Moves the arrow 76px to the left margin
            iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 155px !important;'});

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







