$(document).ready(function () {
    // Fonction qui parcours les div views et edits ehttp://stackoverflow.com/questions/6409505/document-getelementbyid-is-not-a-functiont cache et affiche au besion
    function refreshForm(id){
        $.each($('.views'), function () {
            // Si l'id correspond, on cache le div sinon on l'affiche
            if($(this).attr('id') == 'view_' + id){
                $(this).attr('hidden', true);
            }else{
                $(this).removeAttr('hidden');
            }
        })
        $.each($('.edits'), function () {
            // Si l'id correspond, on l'affiche le div sinon on cache
            if($(this).attr('id') == 'edit_' + id){
                $(this).removeAttr('hidden');
            }else{
                $(this).attr('hidden', true);
            }
        })
    }
    // Evenement sur le clique des bouton éditer
    $.each($('.edit_button'), function () {
        $(this).click(function () {
            var id = $(this).attr('id');
            refreshForm(id);
        })
    })
    // Evenement sur les bouton annuler
    // On cache tous les champs et affiche toutes les valeurs puis on bloque l'event
    $.each($('.cancel'),function () {
        $(this).click(function (event) {
            $('.views').removeAttr('hidden');
            $('.edits').attr('hidden', true);
            return false;
        })

    })
})