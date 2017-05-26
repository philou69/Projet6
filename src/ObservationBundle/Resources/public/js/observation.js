$(document).ready(function () {

    //Pré-remplissage du champ oiseau
    $('#add_observation_bird').select2({
        theme: "classic"


    });

    $( "select" ).removeClass( "select2-hidden-accessible" )

    //Formatage du datepicker
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy',
        minDate: 0
    });
    $('#datepicker').datepicker("setDate", new Date())
    $('#datepicker').datepicker().on('changeDate', function(ev){
        $('#datepicker').datepicker('hide');

    });


    //Formatage de l'upload de photo
    var imgURL1 ,
        img1 ,
        imgURL2,
        img2;
    var div = document.getElementById("picBird");

    //Reset de l'upload des photos
    $( "#closePic" ).click(function() {
        $('#add_observation_pictures').val("");

        if (img1 && img2){

            img1.remove();
            img2.remove();

        } else {
            if(img1) {

                img1.remove();

            } else if(img2){

                img2.remove();
            }
        }
    });

    //Recupération de(s )l'image(s)
    document.getElementById("add_observation_pictures").onchange = function (file) {

        //On remove les photos existantes
        if (img1 && img2){

            img1.remove();
            img2.remove();

        } else {
            if(img1) {

                img1.remove();

            } else if(img2){
                img2.remove();
            }
        }

        //On insére les nouvelles photos
        if((file.target.files[0]) && (file.target.files[1])){

            imgURL1 = URL.createObjectURL(file.target.files[0])
            img1 = document.createElement('img');
            img1.id =  "testImg1";
            img1.className = "img-thumbnail";
            img1.style.width = '200px';
            img1.style.marginRight = '10px'
            img1.src = imgURL1;

            imgURL2 = URL.createObjectURL(file.target.files[1])
            img2 = document.createElement('img');
            img2.id =  "testImg2";
            img2.className = "img-thumbnail";
            img2.style.width = '200px';
            img2.style.marginRight = '10px';
            img2.src = imgURL2;

            div.appendChild(img1)
            div.appendChild(img2)

        } else {

            if (file.target.files[0]) {

                imgURL1 = URL.createObjectURL(file.target.files[0]);
                img1 = document.createElement('img');
                img1.id =  "testImg1";
                img1.className = "img-thumbnail";
                img1.style.width = '200px';
                img1.style.marginRight = '10px';
                img1.src = imgURL1;

                div.appendChild(img1)

            } else  if (file.target.files[1]) {

                imgURL2 = URL.createObjectURL(file.target.files[1]);
                img2 = document.createElement('img');
                img2.id =  "testImg2";
                img2.className = "img-thumbnail";
                img2.style.width = '200px';
                img2.style.marginRight = '10px';
                img2.src = imgURL2;

                div.appendChild(img2)
            }
        }
    }


});