'use strict';

$(document).ready(function () {
    $(document).ready(function () {
        // Création de la variable page
        var page = 1;
        // Première requete ajax lors du chargement de la page
        $.ajax({
            url: $('#birds').data('href'),
            dataType: 'html',
            success: function success(code_html, status) {
                _success(code_html);
            }
        });

        //Génération d'un scroll infinie

        // On crée une data pour évité de lancé une requete plusieur fois d'affilé
        // Et une autre pour définir la fin de la page
        $(window).data('ajaxready', true);
        $(window).data('endPage', false);
        // On mets une fonction au scroll
        $(window).scroll(function () {
            // Si le scroll est plus bas que la hauteur de l'écran, on affiche le bouton up

            if ($(window).scrollTop() >= $(window).height()) {
                $('#up').css('display', 'inline');
            } else {
                //sinon on le cache
                $('#up').css('display', 'none');
            }

            // On vérife la valeur de ajaxready ou celle de endPAge
            if ($(window).data('ajaxready') == false || $(window).data('endPage') == true) {
                // Si elle est fausse, on quitte l'event
                return;
            }
            // Sinon on vérife la position du scroll.
            // si l'addition du scroll + la hauteur de l'a vue et unmarge de 150  est égale ou superieur à la longeur de la page, on va lancé une requete ajax
            if ($(window).scrollTop() + $(window).height() + 150 >= $(document).height()) {
                // On commence par passé à false aaxready
                $(window).data('ajaxready', false);
                // On prépare pour la requete
                prepareRequete(false);
                var url = $('#birds').data('href').replace('1', page);
                var parameters = $('#search').val() === '' ? '' : '?search=' + $('#search').val();
                $.ajax({
                    url: url + parameters,
                    dataType: 'html',
                    success: function success(code_html, status) {
                        _success(code_html);
                        // La requete étant finit, on passe ajaxready à true
                        $(window).data('ajaxready', true);
                    }
                });
            }
        });

        // Requete ajax lors d'une recherche
        $('#search').on('keyup', function (event) {
            prepareRequete(true);
            var option = $('#type').val();
            var urlType = $('#search').attr('data-href').replace('lbNom', option);

            var url = urlType + '?search=' + $(this).val();
            $.ajax({
                url: url,
                dataType: 'html',
                success: function success(code_html, status) {
                    $('#birds').empty();
                    _success(code_html);
                }
            });
        });

        // Fonction préparant la zone d'affichage
        function prepareRequete(isSearch) {
            // On affiche le loader
            $('loader').removeAttr('hidden');
            // S'il s'agit d'une recherche on vide le contenue de contentBirds et on met page à 1
            if (isSearch) {
                $('#birds').empty();
                page = 1;
            }
        }

        // Fonction utiliser lors du success d'une requete
        function _success(code_html) {
            // on cache le loader
            $('.loader').attr('hidden', true);
            // On inserre le resultat dans la zone contentBirds
            $('#birds').append(code_html);
            // On récuperer la taille du resultat
            var numbers = Number($('.length').data('length'));
            // On comparse celui-ci à 20 et aux nombres d'oiseaux affiché s'ils correspondent celà signifie qu'il n'y a pas d'autres pages
            if (numbers <= 20 || numbers == $('.bird').length) {
                // On passe endPage à true
                $(window).data('endPage', true);
            } else {
                // Sinon on l'affiche
                $(window).data('endPage', false);
            }
            // On supprime le div comptenant la taille du resultat pour évité les doublons
            $('.length').remove();

            // On incrimente la page pour le prochain add
            page++;
        }

        // Event sur le bouton up-button qui remets le scroll en  haut de page
        $("#up-button").on('click', function (event) {
            $(window).scrollTop(0);
        });
        //                 listener sur les div des oiseaux pour généreer un ien au click
        $(document).on('click', '.bird', function (event) {
            console.log($(this));
            window.document.location = $(this).data('href');
        });
    });
});
//# sourceMappingURL=bird.list.js.map