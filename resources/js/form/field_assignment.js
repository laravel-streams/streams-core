$(function () {

    // Redirect the page when field type changes.
    $('select[name="type"]').on('change', function () {

        var path = window.location.pathname.split('/');

        path.splice(-1, 1);

        window.location.pathname = path.join('/') + '/' + $(this).val();
    });
});
