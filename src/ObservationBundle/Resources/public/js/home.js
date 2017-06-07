$(document).ready(function () {
    $(document).scroll(function () { // check if scroll event happened
        if ($(document).scrollTop() > $(window).height()) { // check if user scrolled more than height of the window
            // Passage des couleur traditionnelles aux élément de la navbar
            $(".navbar-fixed-top >.container").css("background-color", "#99d1c8");
            $(".navbar-fixed-top >.tab-content").css("background-color", "#dbefed");

        } else {
            // On remet la navbar en transparent et on raffiche le bouton start
            $(".navbar-fixed-top >.container").css("background-color", "transparent");

        }
    });
    // Listener sur le bouton start
    $("#start").on('click', function () {
        console.log($(window).height());
        $('html, body').animate({
            'scrollTop': $(window).height()
        }, 1000);
    });

})