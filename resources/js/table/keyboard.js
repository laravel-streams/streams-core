(function (window, document) {

    /**
     * When a key is pressed listen
     * for some common form actions.
     */
    Mousetrap.prototype.stopCallback = function () {
        return false;
    };


    /**
     * ESC
     */
    Mousetrap.bind(['esc'], function (event) {

        if (!event.target.matches('input, textarea, select')) {
            return;
        }

        event.preventDefault();

        event.target.blur();
    });

})(window, document);
