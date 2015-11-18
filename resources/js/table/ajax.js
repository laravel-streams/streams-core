$(function () {

    // Ajax filters
    $('form#filters').on('submit', function (e) {

        e.preventDefault();

        var wrapper = $(this).closest('.modal-content');

        $.get($(this).attr('action'), $(this).serializeArray(), function (data) {
            wrapper.html(data);
        });
    });

    // Ajax clear filters
    $('form#filters a').on('click', function (e) {

        e.preventDefault();

        var wrapper = $(this).closest('.modal-content');

        $.get($(this).attr('href'), $(this).serializeArray(), function (data) {
            wrapper.html(data);
        });
    });

    // Ajax sorting
    $('table.ajax th a').on('click', function (e) {

        e.preventDefault();

        var wrapper = $(this).closest('.modal-content');

        $.get($(this).attr('href'), function (data) {
            wrapper.html(data);
        });
    });

    // Ajax pagination
    $('.pagination a').on('click', function (e) {

        e.preventDefault();

        var wrapper = $(this).closest('.modal-content');

        $.get($(this).attr('href'), function (data) {
            wrapper.html(data);
        });
    });

    // Ajax controls
    $('table.ajax form').on('submit', function (e) {

        e.preventDefault();

        alert($(this).attr('action'));

        $.post($(this).attr('action'), $(this).serializeArray(), function (data) {

            alert(data);
        });
    });
});
