$(document).ready(function () {

    $('[data-toggle="locale"]').click(function (e) {

        e.preventDefault();

        var selected = $(this);
        var form = $(this).closest('form');
        var locale = $(this).data('locale');

        selected.closest('.menu').find('a').removeClass('active');
        selected.removeClass('active').addClass('active');

        form.find('.field[data-locale]').addClass('hidden');
        form.find('.field[data-locale="' + locale + '"]').removeClass('hidden');
    });
});
