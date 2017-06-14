$(function () {

    var adjustment;

    var $tree = $('ul.tree.sortable').sortable({
        handle: '.handle',

        /**
         * Fires when drag just started
         *
         * @param      {$}          $item      The item
         * @param      {Object}     container  The container
         * @param      {Function}   _super     The super
         * @param      {Event}      event      The event
         */
        onDragStart: function ($item, container, _super, event) {

            $item.css({
                height: $item.outerHeight(),
                width: $item.outerWidth()
            });

            $item.addClass('dragged');

            $('body').addClass('dragging');

            adjustment = {
                left: container.rootGroup.pointer.left - $item.offset().left,
                top: container.rootGroup.pointer.top - $item.offset().top
            };

            _super($item, container);
        },

        /**
         * Fires when drag is continuing
         *
         * @param      {$}        $item     The item
         * @param      {Object}   position  The position
         */
        onDrag: function ($item, position) {
            $item.css({
                left: position.left - adjustment.left,
                top: position.top - adjustment.top
            });
        },

        /**
         * Fires when drop was made
         *
         * @param      {$}          $item      The item
         * @param      {Object}     container  The container
         * @param      {Function}   _super     The super
         * @param      {Event}      event      The event
         */
        onDrop: function ($item, container, _super, event) {

            $.post(window.location.href, {
                // This needs to return [0] for some reason..
                items: tree.sortable('serialize').get()[0]
            });

            _super($item, container);
        },

        /**
         * Serialize data
         *
         * @param      {$}          $parent            The parent
         * @param      {$}          $children          The children
         * @param      {Boolean}    parentIsContainer  The parent is container
         *
         * @return     {Array}
         */
        serialize: function ($parent, $children, parentIsContainer) {

            var result = $.extend({}, $parent.data());

            if (parentIsContainer) {
                return [$children];
            } else if ($children[0]) {
                // This needs to return [0] for some reason..
                result.children = $children[0];
            }

            delete result.subContainers;
            delete result.sortable;

            return result;
        }
    });

    /**
     * Hide initial items.
     */
    $tree.find('li').each(function () {

        var $this = $(this);
        var $li = $this.find('li');
        var count = $li.length;
        var collapsed = Cookies.getJSON('tree') || {};

        if (collapsed[$this.data('id')] === true && count) {
            $this.addClass('collapsed').find('.card').first()
                .append('<div class="count">' + count + '</div>');
        }
    });

    /**
     * Toggle displaying children.
     */
    $('ul.tree.sortable .handle').click(function (e) {

        e.preventDefault();

        var $item = $(this).closest('li');
        var collapsed = Cookies.getJSON('tree');
        var count = $item.find('li').length;

        if (!count) {
            return;
        }

        $item.toggleClass('collapsed');

        if (typeof collapsed === 'undefined') {
            collapsed = {};
        }

        collapsed[$item.data('id')] = $item.hasClass('collapsed');

        if ($item.hasClass('collapsed')) {
            $item.find('.card').first()
                .append('<div class="count">' + count + '</div>');
        } else {
            $item.find('.count').first().remove();
        }

        Cookies.set(
            'tree',
            JSON.stringify(collapsed),
            { path: window.location.pathname }
        );
    });
});
