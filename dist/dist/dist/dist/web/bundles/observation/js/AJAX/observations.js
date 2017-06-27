'use strict';

$(document).ready(function () {
    // On viens de chargé la page, on affiche les observations validés
    $.ajax({
        url: $('#valide').data('href'),
        dataType: 'html',
        success: function success(code_html, status) {
            $('#observations').html(code_html);
            $('.loader').attr('hidden', true);
        }
    });

    $('.link-tab').on('click', function () {
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function success(code_html, status) {
                $('#observations').html(code_html);
                $('.loader').attr('hidden', true);
            }
        });
    });
    $(document).on('click', '.pagination', function (event) {
        prepareAjax();
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function success(code_html, status) {
                $('#observations').html(code_html);
                $('.loader').attr('hidden', true);
            }
        });
    });
    $(document).on('click', '.observation', function () {
        window.document.location = $(this).data('href');
    });
    function prepareAjax() {
        $("#content-observations").empty();
        $('.loader').removeAttr('hidden');
    }
});
//# sourceMappingURL=observations.js.map
//# sourceMappingURL=observations.js.map
//# sourceMappingURL=observations.js.map
//# sourceMappingURL=observations.js.map