$(document).ready(function () {

    $('[data-toggle="filters"]').on('click', function (e) {

        e.preventDefault();

        // Toggle filters display.
        $('[data-toggle="filters"]').toggleClass('active');
        $('.table-filters').toggleClass('active').find('input:first-child').focus();
    });

    $('ul.pagination li a').on('click', function (e) {
        e.preventDefault();
        window.location = $(this).attr('href');
    });

});
