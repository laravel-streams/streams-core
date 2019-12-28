(function (window, document) {

    document.addEventListener('click', function (event) {

        if (!event.target.matches('[data-toggle="tab"]')) {
            return;
        }

        let component = event.target.closest('.tabs');

        let tabs = Array.prototype.slice.call(
            component.querySelectorAll('[data-toggle="tab"]')
        );

        let panes = Array.prototype.slice.call(
            component.querySelectorAll('.tabs__pane')
        );

        panes.forEach(function (pane) {
            pane.classList.remove('active');
        })

        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });

        event.target.classList.add('active');

        component.querySelector(event.target.dataset.target).classList.add('active');
    });

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

})(window, document);
