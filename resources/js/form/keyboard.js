$(function () {

    $(window).on('keydown', function (e) {

        /**
         * Listen for ctrl/meta + S (with optional
         * shift) in order to control the form
         * with the first / second action.
         */
        if ((e.ctrlKey || e.metaKey) && String.fromCharCode(e.which).toLowerCase() === 's') {

            var actions = $('form.form .actions').find('button');

            if (!e.shiftKey) {
                actions.eq(0).click();
            } else {
                actions.eq(1).click();
            }

            return false;
        }

        return true;
    });
});
