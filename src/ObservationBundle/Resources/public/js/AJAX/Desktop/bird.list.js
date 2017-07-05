// Requetes AJAX sur la pagination et recherche des oiseaux
// Appeller dans la vue Bird/Desktop/list.html.twig
$(document).ready(function () {
    // Récuperation des differents elements
    var $birds = $('#birds');
    var $search = $('#search');
    var $addBirds = $('#add-birds');
    var $colorBec = $('#color-bec');
    var $colorPlumage = $('#color-plumage');
    var $colorPatte = $('#color-patte');
    var $typeBec = $('#type-bec');
    // Création de la variable page
    var page = 1

    // Première requete ajax lors du chargement de la page
    $.ajax({
        url: $birds.data('href'),
        dataType: 'html',
        success: function (code_html, status) {
            success(code_html)
        }
    })
    // Fonction qui gerer la liste des parametres GET passer aux requetes
    function getParameters() {
        var searchParameter = $search.val() === '' ? '' : 'search=' + $search.val() + '&';
        var becParameter = $colorBec.val() === '' ? '' : 'bec=' + $colorBec.val() + '&';
        var patteParameter = $colorPatte.val() === '' ? '' : 'patte=' + $colorPatte.val() + '&';
        var plumageParameter = $colorPlumage.val() === '' ? '' : 'plumage=' + $colorPlumage.val() + '&';
        var typeBecParameter = $typeBec.val() === '' ? '' : 'typeBec=' + $typeBec.val() + '&';
        var parameters = '?' + searchParameter + becParameter + patteParameter + plumageParameter + typeBecParameter;
        return parameters;
    }

    // Requte Ajax lors du click sur le bouton add
    $addBirds.on('click', function (event) {
        event.preventDefault();
        prepareRequete(false);
        var url = $addBirds.data('href').replace("1", page) + getParameters() ;

        $.ajax({
            url: url,
            dataType: 'html',
            success: function (code_html, status) {
                success(code_html)
            }
        })
    })
    // Requete ajax lors d'une recherche
    $search.on('keyup', function (event) {
        prepareRequete(true );
        let url = $search.data('href') + getParameters();
         $.ajax({
            url: url,
            dataType: 'html',
            success: function (code_html, status) {
                $birds.empty()
                success(code_html)
            }
        })
    })

    // Event sur les select du filtre
    $('select').on('change', function () {
        prepareRequete(true);
        let url = $birds.data('href') + getParameters();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (code_html, status) {
                $birds.empty()
                success(code_html)
            }
        })
    })

    // Fonction préparant la zone d'affichage
    function prepareRequete(isSearch) {
        // On affiche le loader
        $('.loader').removeAttr('hidden');
        // S'il s'agit d'une recherche on vide le contenue de contentBirds et on met page à 1
        if(isSearch){
            $birds.empty();
            page =1
        }
    }

    // Fonction utiliser lors du success d'une requete
    function success(code_html){
        // on cache le loader
        $('.loader').attr('hidden', true)
        // On inserre le resultat dans la zone contentBirds
        $birds.append(code_html)
        // On récuperer la taille du resultat
        var numbers = Number($('.length').data('length'));
        // On comparse celui-ci à 20 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages
        if(numbers <= 20 || numbers == $('.bird').length ){
            // On cache donc le bouton add
            $addBirds.attr('hidden', true);
        }else{
            // Sinon on l'affiche
            $addBirds.removeAttr('hidden');
        }
        // On supprime le div comptenant la taille du resultat pour évité les doublons
        $('.length').remove();

        // On incrimente la page pour le prochain add
        page++;
    }

    // listener sur les div des oiseaux pour généreer un ien au click
    $(document).on('click', '.bird', function (event) {
        window.document.location = $(this).data('href');
    })

})
