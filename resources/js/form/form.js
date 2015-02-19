$(document).ready(function () {

    $('[data-toggle="locale"]').click(function (e) {

        e.preventDefault();

        var selected = $(this);
        var form = $(this).closest('form');
        var locale = $(this).data('locale');

        selected.closest('ul').find('.btn').removeClass('btn-primary').addClass('btn-default');
        selected.removeClass('btn-default').addClass('btn-primary');

        form.find('.form-group').each(function () {

            if ($(this).find('[data-locale="' + locale + '"]').length > 0) {

                $(this).find('[data-locale]').addClass('hidden');
                $(this).find('[data-locale="' + locale + '"]').removeClass('hidden');
            }
        });
    });
});