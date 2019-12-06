(function (window, document) {

    /**
     * When a key is pressed listen
     * for some common form actions.
     */
    Mousetrap.prototype.stopCallback = function () {
        return false;
    };


    /**
     * Focus on the first input.
     */
    let filters = Array.prototype.slice.call(
        document.querySelectorAll('.table__filter input')
    );

    filters.some(function (filter) {
        if (filter.type !== 'hidden') {
            filter.focus();
            return true;
        }
    });


    /**
     * ESC
     */
    Mousetrap.bind(['esc'], function (event) {

        if (!event.target.matches('input, textarea, select, button')) {
            return;
        }

        event.preventDefault();

        event.target.blur();
    });

})(window, document);
