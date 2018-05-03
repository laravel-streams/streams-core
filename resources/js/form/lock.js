(function (window, document) {

    let links = Array.prototype.slice.call(
        document.querySelectorAll('[data-refresh-locks]')
    );

    links.forEach(function (link) {

        link.addEventListener('click', function (event) {

            event.preventDefault();

            window.location.reload();
        });
    });

    window.addEventListener('unload', function () {

        let request = new XMLHttpRequest();

        request.open('GET', REQUEST_ROOT_PATH + '/locks/release', true);
        request.setRequestHeader('Content-Type', 'application/json');

        request.send();
    });

    setInterval(function () {

        let request = new XMLHttpRequest();

        request.open('GET', REQUEST_ROOT_PATH + '/locks/touch', true);
        request.setRequestHeader('Content-Type', 'application/json');

        request.send();

    }, 55 * 1000);

})(window, document);
