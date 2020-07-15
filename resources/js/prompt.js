(function (window, document) {

    document.addEventListener('click', function (event) {

        if (!event.target.matches('[data-toggle="prompt"]')) {
            return;
        }

        event.preventDefault();

        let match = event.target.dataset.match;

        app.swal({
            text: event.target.dataset.message.replace(':match:', match),
            title: event.target.dataset.title || null,
            icon: event.target.dataset.icon || null,
            closeOnEsc: event.target.dataset.esc == undefined ? false : (event.target.dataset.esc == 'true'),
            closeOnClickOutside: event.target.dataset.outside == undefined ? false : (event.target.dataset.outside == 'true'),
            content: "input",
            buttons: {
                cancel: {
                    visible: true,
                    text: event.target.dataset.cancel_text || 'Cancel'
                },
                confirm: {
                    closeModal: event.target.dataset.close == undefined ? false : (event.target.dataset.close == 'true'),
                    text: event.target.dataset.confirm_text || 'Yes'
                },
            }
        }).then((value) => {

            if (value === null) {

                app.swal.close();

                return false;
            }

            if (value === match) {

                document.querySelector('.swal-content__input').classList.add('swal-content__input-success');

                event.target.dataset.toggle = 'prompted';

                /**
                 * Simulate a native click and let
                 * the default/intended action happen.
                 */
                event.target.click();
            } else {

                app.swal(config).then(callback);

                document.querySelector('.swal-content__input').classList.add('swal-content__input-error');
            }
        });
    });

})(window, document);
