/**
 * Bind keymaps.
 */
let keymaps = Array.prototype.slice.call(
    document.querySelectorAll('[data-keymap]')
);

keymaps.forEach(function (target) {

    mousetrap.bind([target.dataset.keymap], function (event) {

        if (!event.target.matches('body')) {
            return;
        }

        event.preventDefault();

        if (target.matches('input, textarea, select')) {
            
            target.focus();

            return;
        }

        target.click();
    });
});


/**
 * When a key is pressed listen
 * for some common form actions.
 */
mousetrap.prototype.stopCallback = function () {
    return false;
};


/**
 * ESC
 */
mousetrap.bind(['esc'], function (event) {

    if (!event.target.matches('input, textarea, select, button')) {
        return;
    }

    event.preventDefault();

    event.target.blur();
});


/**
 * Show Shortcuts
 */

mousetrap.bind('?', function (event) {

    if (event.target.matches('input, textarea, select, button')) {
        return;
    }

    event.preventDefault();

    alert('Display available keyboard shortcuts.');
});
