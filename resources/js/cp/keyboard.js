/**
 * Bind keymaps.
 */
let keymaps = Array.prototype.slice.call(
    document.querySelectorAll('[data-keymap]')
);

keymaps.forEach(function (target) {

    app.mousetrap.bind([target.dataset.keymap], function (event) {

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
app.mousetrap.prototype.stopCallback = function () {
    return false;
};


/**
 * ESC
 */
app.mousetrap.bind(['esc'], function (event) {

    if (!event.target.matches('input, textarea, select, button')) {
        return;
    }

    event.preventDefault();

    event.target.blur();
});


/**
 * Show Shortcuts
 */

app.mousetrap.bind('?', function (event) {

    if (event.target.matches('input, textarea, select, button')) {
        return;
    }

    event.preventDefault();

    alert('Display available keyboard shortcuts.');
});
