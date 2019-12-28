(function () {

    /**
     * If the window location contains
     * a has then try and open it's tab.
     */
    let initial = document.querySelector('[data-toggle="tab"][data-target="' + document.location.hash + '"]');

    if (document.location.hash && initial) {
        initial.click();
    }

    /**
     * Listen for popstate changes
     * to manage tabs that are open.
     */
    window.addEventListener("popstate", function (event) {

        let popped = document.querySelector('[data-toggle="tab"][data-target="' + document.location.hash + '"]');

        if (document.location.hash && popped) {

            event.preventDefault();

            popped.click();
        }
    });

});


$(function () {

    // Focus on the first input.
    $('form.ajax').on('submit', function (e) {

        e.preventDefault();

        $.post($(this).attr('action'), $(this).serializeArray(), function (data) {

            if (!data.success) {

                messages = [];

                $.each(data.errors, function (field, errors) {
                    messages.push(errors.join('\n'));
                });

                alert(messages.join('\n'));

                return false;
            }

            if (!data.redirect) {
                return;
            }

            window.location = data.redirect;
        });
    });
});
