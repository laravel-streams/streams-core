$(function () {

    // Focus on the first input.
    $('form.ajax').on('submit', function (e) {

        e.preventDefault();

        $.post($(this).attr('action'), $(this).serializeArray(), function (data) {

            if (!data.success) {

                messages = '';

                $.each(data.errors, function (field, errors) {
                    messages += errors.join('/n');
                });

                alert(messages);

                return false;
            }

            window.location = data.redirect;
        });
    });
});
