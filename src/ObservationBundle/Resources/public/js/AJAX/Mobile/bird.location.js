$(document).ready(function () {
    $.ajax({
        url: $('#observations').data('href'),
        dataType: 'html',
        success: function (code_html, status) {
            $('#observations').html(code_html);
            $('.loader').attr('hidden', true);
        }
    })
    $(document).on('click', '.page-link', function () {
        $('.loader').removeAttr('hidden');
        $('#observations').empty();
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function (code_html, status) {
                $('#observations').html(code_html);
                $('.loader').attr('hidden', true)
            }
        })
    })

})