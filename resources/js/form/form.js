$(document).ready(function () {

    $('[data-toggle="form-locale"]').click(function () {

        var selected = $(this);
        var form = $(this).closest('form');
        var locale = $(this).data('locale');

        selected.closest('ul').find('li').removeClass('active');
        selected.closest('li').addClass('active');

        form.find('.form-group').each(function () {

            if ($(this).find('[data-locale="' + locale + '"]').length > 0) {

                $(this).find('[data-locale]').addClass('hidden');
                $(this).find('[data-locale="' + locale + '"]').removeClass('hidden');
            }
        });
    });
});