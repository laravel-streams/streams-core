(function () {

    document.addEventListener('click', function (event) {

        if (!event.target.matches('[data-toggle="confirm"]')) {
            return;
        }

        event.preventDefault();

        app.swal({
            text: event.target.dataset.message || null,
            title: event.target.dataset.title || null,
            icon: event.target.dataset.icon || null,
            closeOnEsc: event.target.dataset.esc == undefined ? false : (event.target.dataset.esc == 'true'),
            closeOnClickOutside: event.target.dataset.outside == undefined ? false : (event.target.dataset.outside == 'true'),
            buttons: {
                cancel: {
                    visible: true,
                    text: event.target.dataset.cancel_text || 'Cancel'
                },
                confirm: {
                    closeModal: event.target.dataset.close == undefined ? false : (event.target.dataset.close == 'true'),
                    text: event.target.dataset.confirm_text || 'OK'
                },
            }
        }).then((value) => {
            if (value === true) {

                event.target.dataset.toggle = 'confirmed';

                /**
                 * Simulate a native click and let
                 * the default/intended action happen.
                 */
                event.target.click();
            }
        });
    });

});
