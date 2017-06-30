$(document).ready(function () {
    // Script affichant les sous-menus au survole et cache au quite de la navbar
    $(document).on('mouseover', '[data-navbar="true"]', function () {
        $(this).tab('show');
    })

    $(document).on('mouseleave', 'a',function (event) {
        // On vérifie si on doit fermé un tabs par la presence de data-hide
        if($(this).data('hide')){
            const tabId = $(this).data('hide');
            /* On regarde ou est partie la souris */
            $(document).on('mousemove', function (e) {
                if(e.target.attributes['data-hide'] === undefined){
                    // On est parti sur un endroit ne contenant pas data-hide, on cache la sous nav
                    var dataId = "[data-hide='" + tabId + "']";
                    $(dataId).parent().removeClass('active')
                    $(tabId).removeClass('active');
                    $('.always-active').addClass('active');
                }else{
                    // On est bien sur un lien en rapport avefc une sous nav
                    if(e.target.attributes['data-hide'].value !== tabId){
                        // Mais pas les mêmes, on cache la premiere
                        // On est parti sur un endroit ne contenant pas data-hide, on cache la sous nav
                        var dataId = "[data-hide='" + tabId + "']";
                        $(dataId).parent().removeClass('active')
                        $(tabId).removeClass('active');

                    }
                }

            })
        }
    })
    /* Evnets pour le menu hamburger sur mobile */
    $('#collapse-mobile').on('click', function () {
        // Quand on affiche le menu collapse, on cache la navbar basse pour qu'elle n'empiete pas dessus
        $('.navbar-general').attr('hidden', true)
    })
    $('#collapse-inside').on('click', function () {
        // Qunad on le ferme, on affiche la navbar basse

        $('.navbar-general').removeAttr('hidden');
    })
})
