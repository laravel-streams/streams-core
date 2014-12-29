$(document).ready(function () {

    // Toggle all table actions
    $('[data-toggle="all"]').on('change', function () {

        $(this).closest('table').find(':checkbox').prop('checked', $(this).is(':checked'));
    });

    // Disable / enable actions when checkboxs are checked
    $('input[type="checkbox"]').on('change', function () {

        if ($('input[type="checkbox"]:checked').length > 0) {

            $('.actions .btn').removeAttr('disabled');
        } else {

            $('.actions .btn').attr('disabled', 'disabled');
        }
    });

    // When an action is clicked - do something
    $('[data-action]').on('click', function (e) {

        e.preventDefault();

        $(this).closest('form').attr('action', $(this).data('action')).submit();
    });
});