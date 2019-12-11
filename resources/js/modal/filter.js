(function (window, document) {

    let show = function (item) {
        item.style.display = 'inherit';
    }

    let hide = function (item) {
        item.style.display = 'none';
        item.classList.remove('selected');
    }

    let select = function (item) {
        item.style.display = 'inherit';
        item.classList.add('selected');
    }

    let clearSelection = function (items) {
        items.forEach((item) => item.classList.remove('selected'));
    }

    let visibility = function (items, visible = true) {
        return items.filter((item) => visible == (item.offsetWidth > 0 && item.offsetHeight > 0));
    }

    /**
     * Listen for keydown to filter
     * if focus / target matches.
     */
    document.addEventListener('keyup', function (event) {

        // Up/Down Keys
        if (event.which == 38 || event.which == 40) {
            return;
        }

        if (!event.target.matches('.modal__filter form input')) {
            return;
        }

        event.preventDefault();

        let filter = event.target.closest('.modal__filter');

        let items = Array.prototype.slice.call(
            filter.querySelectorAll('ul > li')
        );

        let selected = items.find((item) => item.classList.contains('selected'));

        /**
         * Filter the list by the items to
         * show only those containing value.
         * 
         * @param {Element} item
         */
        items.forEach(function (item) {

            let text = item.innerText.toLowerCase();

            if (text.indexOf(event.target.value.toLowerCase()) >= 0) {
                show(item);
            } else {
                hide(item);
            }
        });

        let visible = visibility(items);

        /**
         * Select the first visible by default.
         */
        if (visible[0] && (!selected || !(selected.offsetWidth > 0 && selected.offsetHeight > 0))) {
            clearSelection(items);
            select(visible[0]);
        }
    });

    /**
     * Listen for down arrow to
     * move the item selection.
     */
    app.mousetrap.bind(['up', 'down'], function (event) {

        if (!event.target.matches('.modal__filter form input')) {
            return;
        }

        event.preventDefault();

        let filter = event.target.closest('.modal__filter');

        let items = Array.prototype.slice.call(
            filter.querySelectorAll('ul > li')
        );

        if (selected = items.find((item) => item.classList.contains('selected'))) {

            /**
             * If we have a selection then
             * push to the next visible option.
             */
            items.some((item, i) => {
                if (item == selected && item.offsetWidth > 0 && item.offsetHeight > 0) {

                    // UP- (prev) | DOWN+ (next)
                    var index = event.which == 40 ? i + 1 : i - 1; // 40 = DOWN

                    if ((target = items[index]) != undefined) {

                        clearSelection(items);
                        select(target);

                        return true;
                    }
                }
            });

            return;
        }

        let visible = visibility(items);

        /**
         * Select the first visible by default.
         */
        if (visible[0] && (!selected || !(selected.offsetWidth > 0 && selected.offsetHeight > 0))) {
            clearSelection(items);
            select(visible[0]);
        }
    });

    // // Don't submit on return.
    // form.on('submit', function () {
    //     return false;
    // });

    // input.focus();

    // input.on('keydown', function (e) {

    //     /**
    //      * Capture the down arrow.
    //      */
    //     if (e.which == 40) {

    //         if (selected) {

    //             /**
    //              * If we have a selection then
    //              * push to the next visible option.
    //              */
    //             if (selected.nextAll(':visible').length) {
    //                 items.find('a').removeClass('active');
    //                 selected = selected.nextAll(':visible').first();
    //                 selected.find('a').addClass('active');
    //             }
    //         } else {

    //             /**
    //              * Otherwise select the first
    //              * visible option in the list.
    //              */
    //             selected = items.filter(':visible').first();
    //             selected.find('a').addClass('active');
    //         }
    //     }

    //     /**
    //      * Capture the up arrow.
    //      */
    //     if (e.which == 38) {

    //         if (selected) {

    //             /**
    //              * If we have a selection then push
    //              * to the previous visible option.
    //              */
    //             if (selected.prevAll(':visible').length) {
    //                 items.find('a').removeClass('active');
    //                 selected = selected.prevAll(':visible').first();
    //                 selected.find('a').addClass('active');
    //             }
    //         } else {

    //             /**
    //              * Otherwise select the last
    //              * visible option in the list.
    //              */
    //             selected = items.filter(':visible').last();
    //             selected.find('a').addClass('active');
    //         }
    //     }

    //     /**
    //      * Capture the enter key.
    //      */
    //     if (e.which == 13) {

    //         if (selected) {

    //             /**
    //              * If the key press was the return
    //              * key and we have a selection
    //              * then follow the link.
    //              */
    //             if (selected.find('a').hasClass('has-click-event') || selected.find('a').hasClass('ajax')) {
    //                 selected.find('a').trigger('click');
    //             } else {

    //                 /**
    //                  * If nothing is selected
    //                  * there's nothing to do.
    //                  */
    //                 if (!selected.length) {
    //                     return false;
    //                 }

    //                 /**
    //                  * If control or the meta key is
    //                  * being held open a new window.
    //                  */
    //                 if (e.ctrlKey || e.metaKey) {
    //                     window.open(selected.find('a').attr('href'), "_blank");

    //                     modal.modal('hide');
    //                 } else {
    //                     window.location = selected.find('a').attr('href');
    //                 }

    //                 modal.find('.modal-content').append('<div class="modal-loading"><div class="active large loader"></div></div>');
    //             }
    //         }
    //     }

    //     /**
    //      * Capture up and down arrows.
    //      */
    //     if (e.which == 38 || e.which == 40) {

    //         // store current positions in variables
    //         var start = input[0].selectionStart,
    //             end = input[0].selectionEnd;

    //         // restore from variables...
    //         input[0].setSelectionRange(start, end);

    //         e.preventDefault();
    //     }
    // });

    // input.on('keyup', function (e) {

    //     /**
    //      * If the keyup was a an arrow
    //      * up or down then skip this step.
    //      */
    //     if (e.which == 38 || e.which == 40) {
    //         return;
    //     }

    //     var value = $(this).val();

    //     /**
    //      * Filter the list by the items to
    //      * show only those containing value.
    //      */
    //     items.each(function () {
    //         if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
    //             $(this).show();
    //         } else {
    //             $(this).hide();
    //         }
    //     });

    //     /**
    //      * If we don't have a selected item
    //      * then choose the first visible option.
    //      */
    //     if (!selected || !selected.is(':visible')) {
    //         selected = items.filter(':visible').first();
    //         selected.find('a').addClass('active');
    //     }
    // });


})(window, document);
