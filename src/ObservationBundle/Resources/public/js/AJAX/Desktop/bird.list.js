// Requetes AJAX sur la pagination et recherche des oiseaux
// Appeller dans la vue Bird/Desktop/list.html.twig
$(document).ready(function () {
    // Création de la variable page
    var page = 1
    // Variable contenant la hauteur du scroll
    var scrollHeight = $(window).scrollTop();
    // Première requete ajax lors du chargement de la page
    $.ajax({
        url: getUrl(),
        dataType: 'html',
        success: function (code_html, status) {
            success(code_html)
        }
    })

    // Requte Ajax lors du click sur le bouton add
    $('#add-birds').on('click', function () {
        prepareRequete(false)
        $.ajax({
            url: getUrl(),
            dataType: 'html',
            success: function (code_html, status) {
                success(code_html)
            }
        })
    })
    // Requete ajax lors d'une recherche
    $('#search').on('keyup', function (event) {
        prepareRequete(true)
        $.ajax({
            url: getUrl(),
            dataType: 'html',
            success: function (code_html, status) {
                $('#birds').empty()
                success(code_html)
            }
        })
    })

    // Fonction générant l'url des requetes ajax
    function getUrl() {
        // On vérifie le contenue de l'input search,
        // S'il n'est pas vide on créer un parametre GET search avec sa valeur
        var parameter = $('#search').val() == '' ? '' : '?search=' + $('#search').val();
        var url = '/NAO/web/app_dev.php/bird/pagination/' + page + parameter;

        return '/NAO/web/app_dev.php/bird/pagination/' + page + parameter;
    }

    // Fonction préparant la zone d'affichage
    function prepareRequete(isSearch) {
        // On affiche le loader
        $('.loader').removeAttr('hidden');
        // S'il s'agit d'une recherche on vide le contenue de contentBirds et on met page à 1
        if(isSearch){
            console.log('coucou')
            $('#birds').empty();
            page =1
        }
        // On passe la hauteur du scroll à la variable scrollHeigth
        scrollHeight = $(window).scrollTop();
    }

    // Fonction utiliser lors du success d'une requete
    function success(code_html){
        // On bloque la vue sur la hauteur du scroll
        $(window).scrollTop(scrollHeight);
        // on cache le loader
        $('.loader').attr('hidden', true)
        // On inserre le resultat dans la zone contentBirds
        $('#birds').append(code_html)
        // On récuperer la taille du resultat
        var numbers = Number($('.length').data('length'));
        // On comparse celui-ci à 20 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages
        if(numbers <= 20 || numbers == $('.bird').length ){
            // On cache donc le bouton add
            $('#add-birds').attr('hidden', true);
        }else{
            // Sinon on l'affiche
            $('#add-birds').removeAttr('hidden');
        }
        // On supprime le div comptenant la taille du resultat pour évité les doublons
        $('.length').remove();

        // On incrimente la page pour le prochain add
        page++;
    }
    // listener sur les div des oiseaux pour généreer un ien au click
    $(document).on('click', '.bird', function (event) {
        console.log($(this))
        window.document.location = $(this).data('href');
    })


    $(window).scroll(function () {
        console.log($(window).height() + 'ecran')
        console.log($(document).height() + ' document')
        console.log($(window).scrollTop() + 'scroll')

        // On vérifie si le document fait 2 fois la taille de l'ecran et si le haut du scroll est superieur à 2 fois la taille de l'écran
        if(($(window).height() * 2) < $(document).height() && $(window).scrollTop() > ($(window).height() *2) ){
            // Dans ce cas on affiche le bouton up
            $('#up').css('display', 'inline');
        }else {
            // Sinon on le cache
            $('#up').css('display', 'none');
        }
    })
    $('#up-button').on('click', function(){
        // Si on clique sur le bouton up, on reviens tout en haut du document
        $(window).scrollTop(0);
    })
})
