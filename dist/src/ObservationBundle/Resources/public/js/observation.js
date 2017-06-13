'use strict';

$(document).ready(function () {

    $('#add_observation_bird').select2().hide;
    $('#add_observation_bird').hide();

    // Formatage du datepicker
    $.datepicker.regional['fr'] = {
        altField: "#datepicker",
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        weekHeader: 'Sm',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        minDate: 0,
        maxDate: '+12M +0D',
        numberOfMonths: 2,
        showButtonPanel: true
    };
    $.datepicker.setDefaults($.datepicker.regional['fr']);
    //$('#datepicker').datepicker("setDate", new Date());
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#datepicker').datepicker().on('changeDate', function () {
        $('#datepicker').datepicker('hide');
    });

    //$('#datepicker').datepicker("setDate", new Date());


    document.getElementById("add_observation_location_latitude").required = false;
    document.getElementById("add_observation_location_longitude").required = false;

    if (document.getElementById('getBird')) {
        document.getElementById("add_observation_bird").required = false;
    }
    var idPicture = void 0,
        idPicturesOne = void 0,
        idPicturesTwo = void 0;

    //Formatage de l'upload de photo
    var imgURL1 = void 0,
        img1 = void 0,
        imgURL2 = void 0,
        img2 = void 0;

    var div = document.getElementById("picBird");

    //Reset de l'upload des photos
    $(".close").click(function () {
        $('#closePic').attr('hidden', true);
        $('#add_observation_pictures_first').val("");
        $('#add_observation_pictures_second').val("");

        if (img1 && img2) {

            img1.remove();
            img2.remove();
        } else {
            if (img1) {

                img1.remove();
            } else if (img2) {

                img2.remove();
            }
        }
    });

    //Recupération de(s )l'image(s)
    document.getElementById("add_observation_pictures_first").onchange = function () {
        idPicture = 'add_observation_pictures_first';
    };

    document.getElementById("add_observation_pictures_first").onchange = function (file) {
        console.log('test');
        //On remove les photos existantes
        if (img1 && img2) {

            img1.remove();
            img2.remove();
        } else {
            if (img1) {

                img1.remove();
            } else if (img2) {
                img2.remove();
            }
        }

        //On insére les nouvelles photos
        if (file.target.files[0] && file.target.files[1]) {

            imgURL1 = URL.createObjectURL(file.target.files[0]);
            img1 = document.createElement('img');
            img1.id = "testImg1";
            // img1.className = "img-thumbnail";
            // img1.style.width = '200px';
            // img1.style.marginRight = '10px'
            img1.src = imgURL1;

            imgURL2 = URL.createObjectURL(file.target.files[1]);
            img2 = document.createElement('img');
            img2.id = "testImg2";
            // img2.className = "img-thumbnail";
            // img2.style.width = '200px';
            // img2.style.marginRight = '10px';
            img2.src = imgURL2;

            div.appendChild(img1);
            div.appendChild(img2);
        } else {

            if (file.target.files[0]) {

                imgURL1 = URL.createObjectURL(file.target.files[0]);
                img1 = document.createElement('img');
                img1.id = "testImg1";
                // img1.className = "img-thumbnail";
                // img1.style.width = '200px';
                // img1.style.marginRight = '10px';
                img1.src = imgURL1;

                div.appendChild(img1);
            } else if (file.target.files[1]) {

                imgURL2 = URL.createObjectURL(file.target.files[1]);
                img2 = document.createElement('img');
                img2.id = "testImg2";
                // img2.className = "img-thumbnail";
                // img2.style.width = '200px';
                // img2.style.marginRight = '10px';
                img2.src = imgURL2;

                div.appendChild(img2);
            }
        }

        $('#closePic').attr('hidden', false);
    };

    document.getElementById("add_observation_pictures_second").onchange = function (file) {
        console.log('test');
        //On remove les photos existantes
        if (img1 && img2) {

            img1.remove();
            img2.remove();
        } else {
            if (img1) {

                img1.remove();
            } else if (img2) {
                img2.remove();
            }
        }

        //On insére les nouvelles photos
        if (file.target.files[0] && file.target.files[1]) {

            imgURL1 = URL.createObjectURL(file.target.files[0]);
            img1 = document.createElement('img');
            img1.id = "testImg1";
            // img1.className = "img-thumbnail";
            // img1.style.width = '200px';
            // img1.style.marginRight = '10px'
            img1.src = imgURL1;

            imgURL2 = URL.createObjectURL(file.target.files[1]);
            img2 = document.createElement('img');
            img2.id = "testImg2";
            // img2.className = "img-thumbnail";
            // img2.style.width = '200px';
            // img2.style.marginRight = '10px';
            img2.src = imgURL2;

            div.appendChild(img1);
            div.appendChild(img2);
        } else {

            if (file.target.files[0]) {

                imgURL1 = URL.createObjectURL(file.target.files[0]);
                img1 = document.createElement('img');
                img1.id = "testImg1";
                // img1.className = "img-thumbnail";
                // img1.style.width = '200px';
                // img1.style.marginRight = '10px';
                img1.src = imgURL1;

                div.appendChild(img1);
            } else if (file.target.files[1]) {

                imgURL2 = URL.createObjectURL(file.target.files[1]);
                img2 = document.createElement('img');
                img2.id = "testImg2";
                // img2.className = "img-thumbnail";
                // img2.style.width = '200px';
                // img2.style.marginRight = '10px';
                img2.src = imgURL2;

                div.appendChild(img2);
            }
        }

        $('#closePic').attr('hidden', false);
    };
});
//# sourceMappingURL=observation.js.map