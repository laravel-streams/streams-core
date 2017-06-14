$(function () {

    var $modal = $('.modal.remote.in');
    var $form = $modal.find('form.modal-filter');
    var $input = $form.find('input').focus();
    var $items = $modal.find('ul li');
    var $links = $items.find('a');
    var $selected = null;

    // Don't submit on return.
    $form.on('submit', function () {
        return false;
    });

    // Bind keyboard press event
    $input.on('keydown', function (e) {

        /**
         * Capture the enter key.
         */
        if (e.which === 13) {

            if (!$selected || !$selected.length) {

                /**
                 * If nothing is selected
                 * there's nothing to do.
                 */
                return false;
            }

            var $selectedLinks = $selected.find('a');

            /**
             * If the key press was the return
             * key and we have a selection
             * then follow the link.
             */
            if ($selectedLinks.hasClass('has-click-event')
                || $selectedLinks.hasClass('ajax')) {
                $selectedLinks.trigger('click');
            } else {
                window.location = $selectedLinks.attr('href');

                $modal.find('.modal-content').append('\
<div class="modal-loading">\
    <div class="active large loader"></div>\
</div>\
                ');
            }
        }

        /**
         * Capture up and down arrows.
         */
        if (e.which === 38 || e.which === 40) {

            e.preventDefault();

            if ($selected) {

                /**
                 * If we have a selection then push
                 * to the previous or next visible option.
                 */
                if ($selected.prevAll(':visible').length && e.which === 38) {
                    $links.removeClass('active');
                    $selected = $selected.prevAll(':visible').first();
                    $selected.find('a').addClass('active');
                }

                if ($selected.nextAll(':visible').length && e.which === 40) {
                    $links.removeClass('active');
                    $selected = $selected.nextAll(':visible').first();
                    $selected.find('a').addClass('active');
                }
            } else {

                /**
                 * Otherwise select the first or the last
                 * visible options in the list.
                 */
                if (e.which === 38) {
                    $selected = $items.filter(':visible').first();
                }

                if (e.which === 40) {
                    $selected = $items.filter(':visible').last();
                }

                $selected.find('a').addClass('active');
            }

            // store current positions in variables
            var start = $input[0].selectionStart;
            var end = $input[0].selectionEnd;

            // restore from variables...
            $input[0].setSelectionRange(start, end);
        }
    });

    $input.on('keyup', function (e) {

        /**
         * If the keyup was a an arrow
         * up or down then skip this step.
         */
        if (e.which === 38 || e.which === 40) {
            return;
        }

        var value = $(this).val();

        /**
         * Filter the list by the items to
         * show only those containing value.
         */
        $items.each(function () {

            var $this = $(this);

            if ($this.text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                $this.show();
            } else {
                $this.hide();
            }
        });

        /**
         * If we don't have a selected item
         * then choose the first visible option.
         */
        if (!$selected || !$selected.is(':visible')) {
            $selected = $items.filter(':visible').first();
            $selected.find('a').addClass('active');
        }
    });
});

