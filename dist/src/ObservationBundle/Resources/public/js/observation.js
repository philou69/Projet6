'use strict';

$(document).ready(function () {

    $('#add_observation_bird').select2();
    $('#add_observation_bird').hide();

    //Formatage du datepicker
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy',
        minDate: 0
    });
    $('#datepicker').datepicker("setDate", new Date());
    $('#datepicker').datepicker().on('changeDate', function () {
        $('#datepicker').datepicker('hide');
    });
});

document.getElementById("add_observation_location_latitude").required = false;
document.getElementById("add_observation_location_longitude").required = false;

if (document.getElementById('getBird')) {
    document.getElementById("add_observation_bird").required = false;
}

//Formatage de l'upload de photo
var imgURL1 = void 0,
    img1 = void 0,
    imgURL2 = void 0,
    img2 = void 0;

var div = document.getElementById("picBird");

//Reset de l'upload des photos
$(".close").click(function () {
    $('#closePic').attr('hidden', true);
    $('#add_observation_files').val("");

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
document.getElementById("add_observation_files").onchange = function (file) {

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
//# sourceMappingURL=observation.js.map