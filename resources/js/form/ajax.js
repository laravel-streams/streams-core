$(function () {

    // Focus on the first input.
    $('form.ajax').on('submit', function (e) {

        e.preventDefault();

        $.post($(this).attr('action'), $(this).serializeArray(), function (data) {

            if (data.errors.length) {
                alert(data.errors.join('\n'));

                return false;
            }

            if (data.redirect) {
                window.location = data.redirect;
            } else {
                $('.modal').modal('hide');
            }
        });
    });
});
