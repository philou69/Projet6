$(document).ready(function ()
{

    //Selecteur avec champ de saisie
    $('#filters-gallerie').select2().hide;

    // Récuperation des differents elements
    let pictures = $('#pictures');
    let filters = $('#filters-gallerie');
    // Création de la variable page
    let page = 1;

    // Première requête ajax lors du chargement de la page
    $.ajax({
        url: pictures.data('href'),
        dataType: 'html',
        success: function (code_html, status)
        {
            success(code_html)

            // Get the modal Picture remplissage des différents éléments
            let modal = document.getElementById('myModal');

            $('#list-gallery img').on('click', function ()
            {

                let modalImg = document.getElementById('picZoom');
                let captionText = document.getElementById("caption");

                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            })
        }
    })

    // Event sur les select du filtre
    $('select').on('change', function () {
        prepareRequete(true);
        let url = pictures.data('href') + getParameters();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (code_html, status) {
                pictures.empty()
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
    })

    // Fonction qui gerer la liste des parametres GET passer aux requetes
    function getParameters() {
        let filtersParameter = filters.val() === '' ? '' : 'filters=' + filters.val();

        // let parameters = '?' + filtersParameter;
        return parameters= '?' + filtersParameter;
    }

    //Génération d'un scroll infini

    // On crée une data pour éviter de lancer une requête plusieur fois d'affilé
    // Et une autre pour définir la fin de la page
    $(window).data('ajaxready', true);
    $(window).data('endPage', false);

    // On mets une fonction au scroll
    $(window).scroll(function () {
        // Si le scroll est plus bas que la hauteur de l'écran, on affiche le bouton up

        if ($(window).scrollTop() >= $(window).height())
        {
            //ON l'affcihe
            $('#up').css('display', 'inline')
        }
        else
        {
            //sinon on le cache
            $('#up').css('display', 'none')
        }

        // On vérife la valeur de ajaxready ou celle de endPAge
        if ($(window).data('ajaxready') === false || $(window).data('endPage') === true)
        {
            // Si elle est fausse, on quitte l'event
            return;
        }
        // Sinon on vérife la position du scroll.
        // si l'addition du scroll + la hauteur de l'a vue et une marge de 150  est égale ou superieure à la longeur de la page, on va lancer une requête ajax

        if (($(window).scrollTop() + $(window).height() + 150 ) >= $(document).height())
        {
            // On commence par passer à false ajaxready
            $(window).data('ajaxready', false);

            // On prépare pour la requête
            prepareRequete(false);
            let url = pictures.data('href').replace('1', page) + getParameters();

            $.ajax({
                url: url,
                dataType: 'html',
                success: function (code_html, status)
                {
                    success(code_html)

                    // Get the modal remplissage des différents éléments
                    let modal = document.getElementById('myModal');

                    $('#list-gallery img').on('click', function ()
                    {

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
    function prepareRequete(isSearch)
    {
        // On affiche le loader
        $('loader').removeAttr('hidden');
        // S'il s'agit d'une recherche on vide le contenu de contentBirds et on met page à 1
        if (isSearch)
        {
            $('#pictures').empty();
            page = 1
        }
    }

    // Fonction utiliser lors du success d'une requête
    function success(code_html)
    {
        // on cache le loader
        $('.loader').attr('hidden', true)
        // On inserre le resultat dans la zone contentBirds
        pictures.append(code_html)
        // On récuperer la taille du resultat
        let numbers = Number($('.length').data('length'));
        // On compare celui-ci à 12 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages

        if (numbers === $('.picture').length )
        {
            // On passe endPage à true
            $(window).data('endPage', true);
        }
        else
        {
            // Sinon on l'affiche
            $(window).data('endPage', false)
        }
        // On supprime la div comptenant la taille du resultat pour éviter les doublons
        $('.length').remove();

        // On incrémente la page pour le prochain add
        page++;
    }

    // Event sur le bouton up-button qui remets le scroll en  haut de page
    $("#up-button").on('click', function (event)
    {
        $(window).scrollTop(0);
    })
})