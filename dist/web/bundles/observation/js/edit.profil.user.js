'use strict';

$(document).ready(function () {
    // Evenement sur le clique des bouton éditer
    $('.edit_button').on('click', function (event) {
        // on recuper l'id de l'input
        var id = '#' + $(this).data('id');
        console.log(id);
        // On lui retire l'attribut disabled
        $(id).removeAttr('disabled');
        $('#action').removeAttr('hidden');
        event.preventDefault();
    });
    // Evenement sur les bouton annuler
    // On cache tous les champs et affiche toutes les valeurs puis on bloque l'event
    $('#cancel-profil').on('click', function () {
        $('[name="edit_user"] input').attr('disabled', 'disabled');
        $('#action').attr('hidden', 'hidden');
        event.preventDefault();
    });

    /**
     * Zone pour le changement de mot de passe
     */
    $('#edit_password').on('click', function (event) {

        var id = '#' + $(this).data('id');
        $('#change_password_oldPassword').removeAttr('disabled');
        $('#new-passwords').removeAttr('hidden');
        $('#action-password').removeAttr('hidden');
        $(this).attr('disabled', 'disabled');
        event.preventDefault();
    });
    $('#cancel-password').on('click', function (event) {
        $('#change_password_oldPassword').attr('disabled');
        $('#new-passwords').attr('hidden', 'hidden');
        $('#action-password').attr('hidden', 'hidden');
        $('#edit_password').removeAttr('disabled');
        event.preventDefault();
    });
});
//# sourceMappingURL=edit.profil.user.js.map