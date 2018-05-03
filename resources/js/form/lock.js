(function (window, document) {

    setInterval(function () {

        let request = new XMLHttpRequest();

        request.open('GET', REQUEST_ROOT_PATH + '/locks/touch', true);
        request.setRequestHeader('Content-Type', 'application/json');

        request.send();

    }, 55 * 1000);

})(window, document);
