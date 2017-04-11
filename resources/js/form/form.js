$(function () {

    var $form = $('form.form');

    // Focus on the first input.
    $form.find('input:visible').first().focus();

    // Highlight tabs containing errors.
    $form.find('.has-danger').each(function () {

        var $field = $(this);
        var $pane = $field.closest('.tab-pane');

        if (!$pane.length) {
            return;
        }

        $form
            .find('[data-toggle="tab"][href="#' + $pane.attr('id') + '"]')
            .addClass('text-danger');
    });

    // Set active tabs in a coooookie (crisp).
    var $tabs = $form.find('[data-toggle="tab"]');

    $tabs.on('click', function () {
        Cookies.set(
            'form::tab',
            this.href.replace(window.location.href, '')
        );
    });

    // Unset if we're not reloading the same form.
    if (document.referrer != window.location.href) {
        Cookies.remove('form::tab');
    }
});
