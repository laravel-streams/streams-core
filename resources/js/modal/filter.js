(function (window, document) {

    /**
     * Show the specified item.
     *
     * @param {Element} item
     */
    let show = function (item) {
        item.style.display = 'inherit';
    }

    /**
     * Hide the specified item.
     *
     * @param {Element} item
     */
    let hide = function (item) {
        item.style.display = 'none';
        item.classList.remove('selected');
    }

    /**
     * Select the specified item.
     * 
     * @param {Element} item 
     */
    let select = function (item) {
        item.style.display = 'inherit';
        item.classList.add('selected');
    }

    /**
     * Clear the selected item.
     * 
     * @param {Array} items 
     */
    let clearSelection = function (items) {
        items.forEach((item) => item.classList.remove('selected'));
    }

    /**
     * Return only items that are
     * of the specified visibility.
     * 
     * @param {Array} items 
     * @param {Boolean} visible 
     */
    let visibility = function (items, visible = true) {
        return items.filter((item) => visible == (item.offsetWidth > 0 && item.offsetHeight > 0));
    }

    /**
     * Return the initial variables
     * for the filter component.
     * 
     * @param {Element} filter 
     */
    let setup = function (filter) {

        let items = Array.prototype.slice.call(
            filter.querySelectorAll('ul > li')
        );

        let selected = items.find((item) => item.classList.contains('selected'))

        return [items, selected];
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

        let [items, selected] = setup(filter);

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

        let [items, selected] = setup(filter);

        let visible = visibility(items);

        if (selected) {

            /**
             * If we have a selection then
             * push to the next visible option.
             */
            visible.some((item, i) => {
                if (item == selected && item.offsetWidth > 0 && item.offsetHeight > 0) {

                    // UP- (prev) | DOWN+ (next)
                    var index = event.which == 40 ? i + 1 : i - 1; // 40 = DOWN

                    if ((target = visible[index]) != undefined) {

                        clearSelection(items);
                        select(target);

                        return true;
                    }
                }
            });

            return;
        }

        /**
         * Select the first visible by default.
         */
        if (visible[0] && (!selected || !(selected.offsetWidth > 0 && selected.offsetHeight > 0))) {
            clearSelection(items);
            select(visible[0]);
        }
    });

})(window, document);
