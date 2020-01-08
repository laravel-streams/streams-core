/**
 * Focus on the first input.
 */
let inputs = Array.prototype.slice.call(
    document.querySelectorAll('.field__input input')
);

inputs.some(function (input) {
    if (input.type !== 'hidden') {
        input.focus();
        return true;
    }
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

    if (!event.target.matches('input, textarea, select')) {
        return;
    }

    event.preventDefault();

    event.target.blur();
});


/**
 * Control + S
 */
app.mousetrap.bind(['ctrl+s', 'command+s'], function (event) {

    if (!event.target.matches('input, textarea, select')) {
        return;
    }

    event.preventDefault();

    let actions = Array.prototype.slice.call(
        event.target.closest('form').querySelectorAll('.form__actions button')
    );

    actions[0].click();
});


/**
 * Control + Shift + S
 */
app.mousetrap.bind(['ctrl+shift+s', 'command+shift+s'], function (event) {

    if (!event.target.matches('input, textarea, select')) {
        return;
    }

    event.preventDefault();

    let actions = Array.prototype.slice.call(
        event.target.closest('form').querySelectorAll('.form__actions button')
    );

    actions[1].click();
});
