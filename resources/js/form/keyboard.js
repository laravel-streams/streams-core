(function (window, document) {

    /**
     * When a key is pressed listen
     * for some common form actions.
     */
    Mousetrap.prototype.stopCallback = function () {
        return false;
    };

    /**
     * Control + S
     */
    Mousetrap.bind(['ctrl+s', 'command+s'], function (event) {

        if (!event.target.matches('input, textarea, select')) {
            return;
        }
        
        // Do the action
    });

    /**
     * Control + Shift + S
     */
    Mousetrap.bind(['ctrl+shift+s', 'command+shift+s'], function (event) {

        event.preventDefault();

        actions[1].click();
    });

})(window, document);
