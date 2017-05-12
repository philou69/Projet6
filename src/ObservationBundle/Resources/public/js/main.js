$(document).ready(function () {
    // Script affichant les sous-menus au survole et cache au quite de la navbar
    $(document).on('mouseover', '[data-toggle="tab"]', function () {
        $(this).tab('show');
    });
})
