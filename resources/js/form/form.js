(function (window, document) {

    let forms = Array.prototype.slice.call(
        document.querySelectorAll('form.form')
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

        /**
         * Focus on the first input.
         */
        inputs.some(function (input) {
            if (input.type !== 'hidden') {
                input.focus();
                return true;
            }
        });

        /**
         * If the form has errors then highlight
         * the tabs containing invalid input.
         */
        panes.forEach(function (pane) {

            if (pane.querySelector('.has-danger')) {
                tabs
                    .filter(tab => tab.hash == '#' + pane.id)
                    .map(tab => tab.classList.add('text-danger'));
            }
        });

        /**
         * If the window location contains
         * a has then try and open it's tab.
         */
        if (document.location.hash && form.querySelector(document.location.hash)) {
            form.querySelector('a[href="' + document.location.hash + '"]').click();
        }

        /**
         * Listen for popstate changes
         * to manage tabs that are open.
         */
        window.addEventListener("popstate", function () {
            if (document.location.hash && form.querySelector(document.location.hash)) {
                form.querySelector('a[href="' + document.location.hash + '"]').click();
            }
        });

        /**
         * Change the window hash and push to
         * the popstate when tabs are changed.
         */
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function (event) {
                if (history.pushState) {
                    history.pushState(null, "Show Tab", event.target.hash);
                } else {
                    window.hash(event.target.hash);
                }
            });
        });
    });
})(window, document);
