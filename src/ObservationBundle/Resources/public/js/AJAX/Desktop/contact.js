$(document).ready(function () {
    $(document).on('click', '.contact-resend', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).data('href'),
            dataType: 'json',
            success: function (code_json) {
                $("#success-message").append(code_json.status);
            }
        })
    })

    $(document).on('click', '.contact-received', function (event) {
        event.preventDefault();
        console.log('coucou')
        $.ajax({
            url: $(this).data('href'),
            dataType: 'json',
            success: function (code_json) {
                $("#success-message").append(code_json.status);
                refresh();
            }
        })
    })

    $(document).on('click', '.contact-answered', function (event) {
        event.preventDefault()
        $.ajax({
            url: $(this).data('href'),
            dataType: 'json',
            success: function (code_json){
            $("#success-message").append(code_json.status);
            refresh();
        }
        })
    })

    function refresh(){
        $.ajax({
            url: $("#messages").data('href'),
            dataType: 'html',
            success: function(code_html){
                $('#messages').html(code_html);
            }
        })
    }
})