$(document).ready(function () {

    $('[data-toggle="locale"]').click(function (e) {

        e.preventDefault();

        var selected = $(this);
        var form = $(this).closest('form');
        var locale = $(this).data('locale');

        selected.closest('ul').find('.btn').removeClass('btn-primary').addClass('btn-default');
        selected.removeClass('btn-default').addClass('btn-primary');

        form.find('.form-group[data-locale]').addClass('hidden');
        form.find('.form-group[data-locale="' + locale + '"]').removeClass('hidden');
    });
});