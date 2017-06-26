'use strict';

$(document).ready(function () {
    // Script affichant les sous-menus au survole et cache au quite de la navbar
    $(document).on('mouseover', '[data-navbar="true"]', function () {
        $(this).tab('show');
    });
    /* Evnets pour le menu hamburger sur mobile */
    $('#collapse-mobile').on('click', function () {
        // Quand on affiche le menu collapse, on cache la navbar basse pour qu'elle n'empiete pas dessus
        $('.navbar-general').attr('hidden', true);
    });
    $('#collapse-inside').on('click', function () {
        // Qunad on le ferme, on affiche la navbar basse
        $('.navbar-general').removeAttr('hidden');
    });
});
//# sourceMappingURL=main.js.map
//# sourceMappingURL=main.js.map