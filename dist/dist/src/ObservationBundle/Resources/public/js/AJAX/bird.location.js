'use strict';

$(document).ready(function () {
    // requete éffectué juste après le chargement de la page
    $.ajax({
        url: $('#observations').data('href'),
        dataType: 'html',
        success: function success(code_html, status) {
            _success(code_html);
        }
    });
    // Listener sur les pagination afin de générer la requete AJAX correspondante
    $(document).on('click', '.page-link', function () {
        $('.loader').removeAttr('hidden');
        $('#observations').empty();
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function success(code_html, status) {
                _success(code_html);
            }
        });
    });
    $(document).on('click', '.observation', function () {
        var href = $(this).data('href');
        window.document.location = $(this).data('href');
    });

    function _success(code_html) {

        $('#observations').html(code_html);
        $('.loader').attr('hidden', true);
    }
});
//# sourceMappingURL=bird.location.js.map
//# sourceMappingURL=bird.location.js.map