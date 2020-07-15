(function (window, document) {

    document.addEventListener('click', function (event) {

        if (!event.target.matches('[data-toggle="modal"]')) {
            return;
        }

        event.preventDefault();


        let loading = '<div class="modal-loading">Loading...</div>';

        /**
         * Pass HTML and return a fragment
         * with executed script in the document.
         * @param data
         * @param modal
         * @return fragment
         */
        function processResponse(data, modal) {

            /**
             * Determine which scripts
             * are already loaded. 
             */
            let loaded = Array.prototype.slice.call(
                document.querySelectorAll('script')
            ).filter(function (script) {
                return script.src != '';
            }).map(function (script) {
                return script.src;
            });

            /**
             * Create a fragment to work with.
             * @type {Document}
             */
            let dom = new DOMParser().parseFromString('<div>' + data + '</div>', 'text/html'),
                fragment = document.createDocumentFragment(),
                childNodes = dom.body.childNodes;

            while (childNodes.length) fragment.appendChild(childNodes[0]);

            let scripts = Array.prototype.slice.call(
                fragment.querySelectorAll('script')
            );

            /**
             * Append scripts to fragment
             * so they are executed.
             * 
             * @type {NodeList}
             */
            scripts.forEach(function (script) {

                if (script.innerHTML) {
                    return;
                }

                if (loaded.includes(script.src)) {
                    return;
                }

                var element = document.createElement('script');

                element.type = script.type;
                element.src = script.src;
                element.async = false;

                script.parentNode.replaceChild(element, script);
            });

            return fragment;
        }

        /**
         * Open a modal with the loading content.
         */
        let modal = new app.tingle.modal({
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: 'Close',
            cssClass: ['modal'],
        });

        /**
         * Open the modal and set loading.
         */
        modal.open();

        modal.setContent(loading);

        /**
         * Send the HTTP request out.
         */
        fetch(event.target.href, {
                credentials: 'same-origin'
            })
            .then(function (response) {
                return response.text();
            }).then(function (data) {

                let fragment = processResponse(data, modal);

                modal.setContent('');
                modal.modalBoxContent.appendChild(fragment);

                /**
                 * Focus on the first visible input.
                 */
                let inputs = Array.prototype.slice.call(
                    modal.modalBoxContent.querySelectorAll('.modal__filter input')
                );

                if (first = inputs.find((input) => (input.offsetWidth > 0 && input.offsetHeight > 0))) {
                    first.focus();
                }
            }).catch(function (error) {
                alert(error);
            });
    });

})(window, document);
