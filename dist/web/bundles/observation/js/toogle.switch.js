'use strict';

$(document).ready(function () {
    // On surveille le toogle switch
    $('#choice').click(function () {
        // On applique la fonction changeState à login et registration
        changeState($('#login'));
        changeState($('#registration'));
    });

    function changeState(element) {
        // On regarde si l'element est visible ou non et on luis passe l'effet inverse
        if (element.attr('hidden')) {
            element.removeAttr('hidden');
        } else {
            element.attr('hidden', true);
        }
    }
});
//# sourceMappingURL=toogle.switch.js.map