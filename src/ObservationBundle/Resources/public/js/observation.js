$(document).ready(function () {

    //Selecteur avec champ de saisie
    $('#add_observation_bird').select2().hide;
    $('#add_observation_bird').hide();

    // Formatage du datepicker
    $.datepicker.regional['fr'] = {
        altField: "#datepicker",
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun',
            'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
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



//resuired a false pour element caché pour validation formulaire
document.getElementById("add_observation_location_latitude").required = false;
document.getElementById("add_observation_location_longitude").required = false;

let imgURL1,
    img1,
    imgURL2,
    img2,
    idPicture;

let div = document.getElementById("picBird");

    // if ($('#add_observation_pictures_1').length) {
    //     $('#add_observation_pictures_1 > div > label').text('Prendre une photo');
    //     $('#add_observation_pictures_1_file').attr('capture', true);
    // }

//Reset de l'upload des photos
    $(".close").click(function () {
    $('#closePic').attr('hidden', true);
        $('#add_observation_pictures').val("");
        $('#add_observation_pictures_2').val("");


        removePicture();
});

    if ($('#getBird').attr('hidden') === 'hidden') {

        document.getElementById("add_observation_bird").required = false;

    }
    ;


//On determine quel boutton est cliqué puis on selectionne le mode
    $('[for=add_observation_pictures_file]').click(function () {
        //On verifie quel bouton est cliqué
        idPicture = 'add_observation_pictures_file';
        console.log(idPicture)

        selectPicture(idPicture);
    });

    $('[for=add_observation_pictures_2_file]').click(function () {
        //On verifie quel bouton est cliqué
        idPicture = 'add_observation_pictures_2_file';
        console.log(idPicture)

        selectPicture(idPicture);
    });


//Recupération de(s )l'image(s)
    function selectPicture(idPicture) {

        document.getElementById(idPicture).onchange = function (file) {
            //On remove les photos existantes
            removePicture();

            //On insére les nouvelles photos
            //Pour 2 photos choisies
            if ((file.target.files[0]) && (file.target.files[1])) {

                imgURL1 = URL.createObjectURL(file.target.files[0])
                img1 = document.createElement('img');
                img1.id = "testImg1";
                img1.src = imgURL1;

                imgURL2 = URL.createObjectURL(file.target.files[1])
                img2 = document.createElement('img');
                img2.id = "testImg2";
                img2.src = imgURL2;

                div.appendChild(img1)
                div.appendChild(img2)

            }
            //Pour une photo choisie
            else {
                if (file.target.files[0]) {

                    imgURL1 = URL.createObjectURL(file.target.files[0]);
                    img1 = document.createElement('img');
                    img1.id = "testImg1";
                    // img1.className = "img-thumbnail";
                    // img1.style.width = '200px';
                    // img1.style.marginRight = '10px';
                    img1.src = imgURL1;

                    div.appendChild(img1)

                }
                else if (file.target.files[1]) {

                    imgURL2 = URL.createObjectURL(file.target.files[1]);
                    img2 = document.createElement('img');
                    img2.id = "testImg2";
                    // img2.className = "img-thumbnail";
                    // img2.style.width = '200px';
                    // img2.style.marginRight = '10px';
                    img2.src = imgURL2;

                    div.appendChild(img2)
                }
            }

            $('#closePic').attr('hidden', false);
        }
    }

    //Effacer les images
    function removePicture() {
        if (img1 && img2) {

            img1.remove();
            img2.remove();

        }
        else {
            if (img1) {

                img1.remove();

            }
            else if (img2) {
                img2.remove();
            }
        }
    }
});