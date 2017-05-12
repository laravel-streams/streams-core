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
});
