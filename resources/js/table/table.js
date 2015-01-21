$(document).ready(function () {

    $('[data-toggle="filters"]').on('click', function (e) {

        e.preventDefault();

        // Toggle filters display.
        $('[data-toggle="filters"]').toggleClass('active');
    });

    $('ul.pagination li a').on('click', function (e) {
        e.preventDefault();
        window.location = $(this).attr('href');
    });

});
