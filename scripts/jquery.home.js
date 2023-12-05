$(document).ready(function() {
    let currentSlide = 1;
    let totalSlides = $('.slide').length;

    function showSlide(index) {
        if (index < 1) {
            currentSlide = totalSlides;
        } else if (index > totalSlides) {
            currentSlide = 1;
        } else {
            currentSlide = index;
        }

        $('.slide').hide();
        $('.slide:nth-child(' + currentSlide + ')').fadeIn();
    }

    $('#carousel').on('click', '.prev', function() {
        console.log("asdsad")
        showSlide(currentSlide - 1);
    });

    $('#carousel').on('click', '.next', function() {
        showSlide(currentSlide + 1);
    });

    showSlide(currentSlide);
});