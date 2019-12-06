(function (window, document) {

    let forms = Array.prototype.slice.call(
        document.querySelectorAll('.form__wrapper form')
    );

    forms.forEach(function (form) {

        let inputs = Array.prototype.slice.call(
            form.querySelectorAll('input')
        );

        let tabs = Array.prototype.slice.call(
            form.querySelectorAll('a[data-toggle="tab"]')
        );

        let panes = Array.prototype.slice.call(
            form.querySelectorAll('.tab__pane')
        );

        let actions = Array.prototype.slice.call(
            form.querySelectorAll('.form__actions button')
        );

        /**
         * Disable actions after the
         * form has been submitted.
         */
        if (!form.classList.contains('ajax')) {

            form.addEventListener('submit', function () {

                let button = document.activeElement;

                if (button && button.tagName == 'BUTTON') {

                    let icon = button.querySelector('i');

                    if (icon) {
                        icon.classList = 'fas fa-sync-alt fa-spin';
                    } else {
                        button.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i>' + button.innerHTML;
                    }
                }

                // NProgress.start({
                //     trickleSpeed: 25,
                //     showSpinner: false,
                // });

                actions.forEach(function (action) {

                    action.classList.add('disabled');

                    action.addEventListener('click', function (event) {

                        event.preventDefault();

                        return false;
                    });
                });

                //NProgress.set(0.70);
            });
        }
    });
})(window, document);
