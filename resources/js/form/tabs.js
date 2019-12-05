(function (window, document) {

    document.addEventListener('click', function (event) {

        if (!event.target.matches('[data-toggle="tab"]')) {
            return;
        }

        let component = event.target.closest('.tabs');

        let active = component.querySelector('.tabs__pane.active');

        if (active) {
            active.classList.remove('active');
        }

        let buttons = Array.prototype.slice.call(
            component.querySelectorAll('[data-toggle="tab"]')
        );

        buttons.forEach(function (button) {
            button.classList.remove('active');
        });

        event.target.classList.add('active');

        component.querySelector(event.target.dataset.target).classList.add('active');
    });

})(window, document);
