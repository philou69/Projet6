'use strict';

$(document).ready(function () {
    $(window).scroll(function () {
        // On vérifie si le document fait au moins 1.5 fois la taille de l'ecran et si le haut du scroll est superieur à la taille de l'écran
        if ($(window).height() * 1.5 < $(document).height() && $(window).scrollTop() > $(window).height()) {
            // Dans ce cas on affiche le bouton up
            $('#up').css('display', 'inline');
        } else {
            // Sinon on le cache
            $('#up').css('display', 'none');
        }
    });
    $('#up-button').on('click', function () {
        // Si on clique sur le bouton up, on reviens tout en haut du document
        $(window).scrollTop(0);
    });
});
//# sourceMappingURL=scroll.desktop.js.map