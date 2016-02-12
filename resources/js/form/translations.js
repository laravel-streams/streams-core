$(function () {

    $('[data-toggle="lang"]').click(function (e) {

        e.preventDefault();

        var selected = $(this);
        var locale = $(this).attr('lang');
        var form = $(this).closest('form');

        selected.closest('ul').find('li').removeClass('active');
        selected.closest('li').addClass('active');

        form.find('.form-group[lang]').addClass('hidden');
        form.find('.form-group[lang="' + locale + '"]').removeClass('hidden');
    });
});
