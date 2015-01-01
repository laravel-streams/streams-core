$(document).ready(function () {

    // Toggle all table actions
    $('[data-toggle="all"]').on('change', function () {

        $(this).closest('table').find(':checkbox').prop('checked', $(this).is(':checked'));
    });
});