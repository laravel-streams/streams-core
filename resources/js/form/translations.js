$(function () {

    $('[data-toggle="lang"]').click(function (e) {

        e.preventDefault();

        var selected = $(this);
        var locale = $(this).attr('lang');
        var form = $(this).closest('form');

        selected.closest('.btn-group').find('button').text(selected.text());
        selected.closest('div').find('a').removeClass('active');
        selected.addClass('active');

        form.find('.form-group[lang]').addClass('hidden');
        form.find('.form-group[lang="' + locale + '"]').removeClass('hidden');
    });
});
