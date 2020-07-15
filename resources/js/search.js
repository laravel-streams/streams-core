//TODO: Vue component instead
export default (function () {
    
    
    /**
     * Open the search component.
     * 
     * @param {Element} search 
     */
    let open = function (search) {
        search.classList.add('-open');
    }

    /**
     * Close the search component.
     * 
     * @param {Element} search 
     */
    let close = function (search) {
        search.classList.remove('-open');
        search.querySelector('form input').value = '';
    }

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
     * for the search component.
     * 
     * @param {Element} search 
     */
    let setup = function (search) {

        let items = Array.prototype.slice.call(
            search.querySelectorAll('ul > li')
        );

        let selected = items.find((item) => item.classList.contains('selected'))

        return [items, selected];
    }

    /**
     * Listen for focus on
     * the search component.
     */
    document.addEventListener('focus', function (event) {

        if (!event.target.matches('.header__search form input')) {
            return;
        }

        event.preventDefault();

        let search = event.target.closest('.header__search');

        search.classList.add('-open');
    });

    /**
     * Listen for blur on
     * the search component.
     */
    document.addEventListener('blur', function (event) {

        if (!event.target.matches('.header__search form input')) {
            return;
        }

        event.preventDefault();

        let search = event.target.closest('.header__search');

        search.classList.remove('-open');
    });

    /**
     * Listen for keydown to search
     * if focus / target matches.
     */
    document.addEventListener('keyup', function (event) {

        // Up/Down Keys
        if (event.which == 38 || event.which == 40) {
            return;
        }

        if (!event.target.matches('.header__search form input')) {
            return;
        }

        event.preventDefault();

        let search = event.target.closest('.header__search');

        let [items, selected] = setup(search);

        /**
         * Search the list by the items to
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
    // app.mousetrap.bind(['up', 'down'], function (event) {

    //     if (!event.target.matches('.header__search form input')) {
    //         return;
    //     }

    //     event.preventDefault();

    //     let search = event.target.closest('.header__search');

    //     let [items, selected] = setup(search);

    //     let visible = visibility(items);

    //     if (selected) {

    //         /**
    //          * If we have a selection then
    //          * push to the next visible option.
    //          */
    //         visible.some((item, i) => {
    //             if (item == selected && item.offsetWidth > 0 && item.offsetHeight > 0) {

    //                 // UP- (prev) | DOWN+ (next)
    //                 var index = event.which == 40 ? i + 1 : i - 1; // 40 = DOWN

    //                 if ((target = visible[index]) != undefined) {

    //                     clearSelection(visible);
    //                     select(target);

    //                     return true;
    //                 }
    //             }
    //         });

    //         return;
    //     }

    //     /**
    //      * Select the first visible by default.
    //      */
    //     if (visible[0] && (!selected || !(selected.offsetWidth > 0 && selected.offsetHeight > 0))) {
    //         clearSelection(items);
    //         select(visible[0]);
    //     }
    // });

    // /**
    //  * Bind (Control || Command) + Space for
    //  * jumping to the global search input.
    //  */
    // app.mousetrap.bind(['command+space', 'ctrl+space'], function (event) {

    //     event.preventDefault();

    //     let search = document.querySelector('.header__search input');

    //     if (!search) {
    //         return;
    //     }

    //     search.focus();
    // });

    /**
     * Listen for focus.
     */
    document.addEventListener('focus', function (event) {

        if (!event.target.matches('.header__search form input')) {
            return;
        }

        event.preventDefault();

        open(document.querySelector('.header__search'));
    }, true);

    /**
     * Listen for blur.
     */
    document.addEventListener('blur', function (event) {

        if (!event.target.matches('.header__search form input')) {
            return;
        }

        event.preventDefault();

        close(document.querySelector('.header__search'));
    }, true);


}());