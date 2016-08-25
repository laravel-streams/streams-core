$(function() {

    // Toggle all table actions
    $('[data-toggle="all"]').on('change', function() {

        $(this).closest('table').find(':checkbox').prop('checked', $(this).is(':checked'));
    });

    // Only allow actions if rows are selected.
    $('table').find(':checkbox').on('change', function() {

        if ($(this).closest('form').find(':checkbox:checked').length) {
            $(this).closest('form').find('.actions').find('button:not([data-ignore])').removeAttr('disabled').removeClass('disabled');
        } else {
            $(this).closest('form').find('.actions').find('button:not([data-ignore])').attr('disabled', 'disabled').addClass('disabled');
        }
    });
});
