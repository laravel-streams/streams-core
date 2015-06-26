$(function () {

    // Focus on the first input.
    $('form.form').on('submit', function (e) {

        e.preventDefault();

        $.post($(this).attr('action'), $(this).serializeArray(), function (data) {

            if (data.errors.length) {
                alert(data.errors.join('\n'));
            } else {
                window.location = data.redirect;
            }
        });
    });
});
