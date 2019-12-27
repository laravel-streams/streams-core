(function (window, document) {

    document.addEventListener('submit', function (event) {

        if (!event.target.matches('[data-async="true"]')) {
            return;
        }

        event.preventDefault();

        alert('Submitting async form.');

        return false;
    });


})(window, document);
