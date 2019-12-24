(function (window, document) {
    alert();
    document.addEventListener('submit', function (event) {
        alert();
        if (!event.target.matches('[data-async="true"]')) {
            return;
        }

        event.preventDefault();

        alert();
    });


})(window, document);
