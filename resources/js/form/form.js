(function (window, document) {

    document.addEventListener('submit', function (event) {

        if (!event.target.matches('[data-async="true"]')) {
            return;
        }

        event.preventDefault();

        fetch(event.target.getAttribute('action'), {
                method: 'POST',
                credentials: 'same-origin',
                body: new FormData(event.target)
            })
            .then(function (response) {
                return response.json();
            }).then(function (data) {

                if (!data.success) {

                    let messages = [];

                    data.errors.forEach(function (field, errors) {
                        messages.push(errors.join('\n'));
                    });

                    alert(messages.join('\n'));

                    return false;
                }

                if (!data.redirect) {
                    return;
                }

                window.location = data.redirect;

            }).catch(function (error) {
                alert(error);
            });
    });


})(window, document);
