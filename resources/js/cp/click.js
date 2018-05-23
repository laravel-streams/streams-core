(function (window, document) {

    let hash = document.location.hash;

    /**
     * Make sure it's a click command.
     */
    if (!hash || hash.lastIndexOf('#click:', 0) !== 0) {
        return;
    }

    /**
     * Grab the selector and
     * make sure we have a target.
     *
     * @type {string}
     */
    let selector = decodeURIComponent(hash.substring(7));

    if (!selector) {
        return;
    }

    let target = document.querySelector(selector);

    /**
     * If we do have a target
     * go ahead and click it.
     */
    if (target) {
        target.click();
    }

})(window, document);
