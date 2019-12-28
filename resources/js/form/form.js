(function () {

    // Shortcut this
    let inputs = Array.prototype.slice.call(
        document.querySelectorAll('.modal form input, form input')
    );

    // Focus on the first input input.
    inputs.some(function (input) {
        if (input.type !== 'hidden') {
            input.focus();
            return true;
        }
    });

})();
