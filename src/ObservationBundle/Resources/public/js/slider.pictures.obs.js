$(document).ready(function () {
    var $previous = $('#previous');
    var $next = $('#next');
    var numberPhoto = $('.picture').length;
    $previous.on('click', function (event) {
        event.preventDefault();
        var idActual ="#" + ($previous.data('id') +1 );
        var idPrevious ='#' + $previous.data('id');
        $(idActual).attr('hidden', 'true');
        $(idPrevious).removeAttr('hidden');
        var id = $previous.data('id') -1;
        $previous.data('id', id);
        if($previous.data('id') === 0){
            $previous.attr('disabled', 'disabled');
        }
        var id = $next.data('id') - 1;
        $next.data('id', id);
        if($next.attr('disabled')){
            $next.removeAttr('disabled');
        }
    })
    $next.on('click', function (event) {
        event.preventDefault();
        var idActual ="#" + ($next.data('id') - 1 );
        var idNext ='#' + $next.data('id');
        $(idActual).attr('hidden', 'true');
        $(idNext).removeAttr('hidden');
        var id = $previous.data('id') +1;
        $previous.data('id', id);
        if($previous.attr('disabled')){
            $previous.removeAttr('disabled')
        }
        var id = $next.data('id') + 1;
        $next.data('id', id);
        if($next.data('id') === numberPhoto + 1){
            $next.attr('disabled', 'disabled');
        }
    })
})