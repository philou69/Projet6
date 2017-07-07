$(document).ready(function () {

    // Get the modal
    let modal = document.getElementById('myModal');

    $('#list-gallery img').on('click', function () {
        console.log('test')
        let modalImg = document.getElementById('img01');
        let captionText = document.getElementById("caption");

        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    })

    $(document).scroll(function () { // check if scroll event happened
        if ($(document).scrollTop() > $(window).height()) { // check if user scrolled more than height of the window
            // Passage des couleur traditionnelles aux élément de la navbar, en enlevant la class narbar-transparent
            $('.navbar-fixed-top').removeClass('navbar-transparent')

            // $(".navbar-fixed-top >#first").css("background-color", "#99d1c8");
            // $(".navbar-fixed-top >.tab-content").css("background-color", "#dbefed");

        } else {
            // On remet la navbar en transparent et on raffiche le bouton start
            $('.navbar-fixed-top').addClass('navbar-transparent')
            // $(".navbar-fixed-top >#first").css("background-color", "transparent");
            // $(".navbar-fixed-top >.tab-content").css("background-color", "transparent");

        }
    });
    // Listener sur le bouton start
    $("#start").on('click', function () {
        // Passage des couleur traditionnelles aux élément de la navbar
        $('.navbar-fixed-top').removeClass('navbar-transparent')
        // $(".navbar-fixed-top >#first").css("background-color", "#99d1c8");
        // $(".navbar-fixed-top >.tab-content").css("background-color", "#dbefed");
    });

})