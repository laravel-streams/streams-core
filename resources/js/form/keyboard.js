$(function () {

    /**
     * Listen for ctrl/meta + S (with optional
     * shift) in order to control the form
     * with the first / second action.
     */
    $(window).bind('keydown', function (e) {

        if (!e.ctrlKey && !e.metaKey) {
            return true;
        }

        if (String.fromCharCode(e.which).toLowerCase() !== 's') {
            return true;
        }

        var actions = $('form.form .actions').find('button');

        if (!e.shiftKey) {
            actions.eq(0).click();
        } else {
            actions.eq(1).click();
        }

        return false;
    });
});
