// Requetes AJAX sur la pagination et recherche des oiseaux
// Appeller dans la vue Bird/Desktop/list.html.twig
$(document).ready(function () {
    // Récuperation des differents elements
    let pictures = $('#pictures');
    let addPicture = $('#add-pictures');

    // Création de la variable page
    let page = 1

    // Première requete ajax lors du chargement de la page
    $.ajax({
        url: pictures.data('href'),
        dataType: 'html',
        success: function (code_html, status) {
            success(code_html)

                // Get the modal
                let modal = document.getElementById('myModal');

                $('#list-gallery img').on('click', function () {
                    let img = $(this).attr('id')
                    let modalImg = document.getElementById('img01');
                    let captionText = document.getElementById("caption");

                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;

                })
        }
    })

    // Requte Ajax lors du click sur le bouton add
    addPicture.on('click', function (event) {
        event.preventDefault();
        prepareRequete(false);
        let url = addPicture.data('href').replace("1", page);

        $.ajax({
            url: url,
            dataType: 'html',
            success: function (code_html, status) {
                success(code_html)

                    // Get the modal
                // Get the modal
                let modal = document.getElementById('myModal');

                $('#list-gallery img').on('click', function () {
                    let modalImg = document.getElementById('img01');
                    let captionText = document.getElementById("caption");

                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                    })
            }
        })
    })


    // Fonction préparant la zone d'affichage
    function prepareRequete(isSearch) {
        // On affiche le loader
        $('.loader').removeAttr('hidden');
        // S'il s'agit d'une recherche on vide le contenue de contentBirds et on met page à 1
        if(isSearch){
            pictures.empty();
            page =1
        }
    }

    // Fonction utiliser lors du success d'une requete
    function success(code_html){
        // on cache le loader
        $('.loader').attr('hidden', true)
        // On inserre le resultat dans la zone contentBirds
        pictures.append(code_html)
        // On récuperer la taille du resultat
        let numbers = Number($('.length').data('length'));
        // On comparse celui-ci à 20 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages
        if(numbers <= 20 || numbers == $('.bird').length ){
            // On cache donc le bouton add
            addPicture.attr('hidden', true);
        }else{
            // Sinon on l'affiche
            addPicture.removeAttr('hidden');
        }
        // On supprime le div comptenant la taille du resultat pour évité les doublons
        $('.length').remove();

        // On incrimente la page pour le prochain add
        page++;
    }

})









