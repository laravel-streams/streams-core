$(function () {

    $('body').on('click', '[data-toggle="lang"]', function (e) {

        e.preventDefault();

        var selected = $(this);
        var locale = selected.attr('lang');
        var form = selected.closest('form');

        var triggers = form.find('[data-toggle="lang"]');
        var group = triggers.closest('.btn-group');
        var toggle = group.find('.dropdown-toggle');
        var dropdown = group.find('.dropdown-menu');

        toggle.text(selected.text());

        dropdown.find('a').removeClass('active');
        selected.addClass('active');

        form.find('.form-group[lang]').addClass('hidden');
        form.find('.form-group[lang="' + locale + '"]').removeClass('hidden');
    });
});
