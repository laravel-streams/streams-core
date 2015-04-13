$(function () {

    // Redirect the page when field type changes.
    $('[data-field="type"] > select').on('change', function () {

        $(this).attr('disabled', 'disabled');

        var path = window.location.pathname.split('/');

        if (path.pop() == 'create') {
            path.push('create');
        }

        path.push($(this).val());

        window.location.pathname = path.join('/');
    });
});
