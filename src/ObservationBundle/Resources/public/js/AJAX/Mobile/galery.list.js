$(document).ready(function () {
    // Récuperation des differents elements
    var pictures = $('#pictures');
    // Création de la variable page
    var page = 1

    // Première requete ajax lors du chargement de la page
    $.ajax({
        url: pictures.data('href'),
        dataType: 'html',
        success: function (code_html, status) {
            success(code_html)

            // Get the modal
            let modal = document.getElementById('myModal');

            $('#list-gallery img').on('click', function () {

                let modalImg = document.getElementById('picZoom');
                let captionText = document.getElementById("caption");

                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            })
        }
    })

    //Génération d'un scroll infinie

    // On crée une data pour évité de lancé une requete plusieur fois d'affilé
    // Et une autre pour définir la fin de la page
    $(window).data('ajaxready', true);
    $(window).data('endPage', false);
    // On mets une fonction au scroll
    $(window).scroll(function () {
        // Si le scroll est plus bas que la hauteur de l'écran, on affiche le bouton up

        if ($(window).scrollTop() >= $(window).height()) {
            $('#up').css('display', 'inline')

        } else {
            //sinon on le cache
            $('#up').css('display', 'none')
        }

        // On vérife la valeur de ajaxready ou celle de endPAge
        if ($(window).data('ajaxready') === false || $(window).data('endPage') === true) {
            // Si elle est fausse, on quitte l'event
            return;
        }
        // Sinon on vérife la position du scroll.
        // si l'addition du scroll + la hauteur de l'a vue et unmarge de 150  est égale ou superieur à la longeur de la page, on va lancé une requete ajax
        if (($(window).scrollTop() + $(window).height() + 150 ) >= $(document).height()) {
            // On commence par passé à false aaxready
            $(window).data('ajaxready', false);
            // On prépare pour la requete
            prepareRequete(false);
            var url = pictures.data('href').replace('1', page);
            $.ajax({
                url: url,
                dataType: 'html',
                success: function (code_html, status) {
                    success(code_html)

                    // Get the modal
                    let modal = document.getElementById('myModal');

                    $('#list-gallery img').on('click', function () {

                        let modalImg = document.getElementById('picZoom');
                        let captionText = document.getElementById("caption");

                        modal.style.display = "block";
                        modalImg.src = this.src;
                        captionText.innerHTML = this.alt;
                    })
                    // La requete étant finit, on passe ajaxready à true
                    $(window).data('ajaxready', true)
                }
            })
        }
    })

    // Fonction préparant la zone d'affichage
    function prepareRequete(isSearch) {
        // On affiche le loader
        $('loader').removeAttr('hidden');
        // S'il s'agit d'une recherche on vide le contenue de contentBirds et on met page à 1
        if (isSearch) {
            $('#pictures').empty();
            page = 1
        }
    }

    // Fonction utiliser lors du success d'une requete
    function success(code_html) {
        // on cache le loader
        $('.loader').attr('hidden', true)
        // On inserre le resultat dans la zone contentBirds
        pictures.append(code_html)
        // On récuperer la taille du resultat
        let numbers = Number($('.length').data('length'));
        // On compare celui-ci à 20 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages
        if (numbers <= 12 || numbers === $('.picture').length ) {
            // On passe endPage à true
            $(window).data('endPage', true);

        } else {
            // Sinon on l'affiche
            $(window).data('endPage', false)

        }
        // On supprime le div comptenant la taille du resultat pour évité les doublons
        $('.length').remove();

        // On incrimente la page pour le prochain add
        page++;
    }

    // Event sur le bouton up-button qui remets le scroll en  haut de page
    $("#up-button").on('click', function (event) {
        $(window).scrollTop(0);
    })

})