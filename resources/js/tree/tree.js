$(function () {

    var adjustment;

    var tree = $('ul.tree.sortable').sortable({
        handle: '.handle',
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
        onDrag: function ($item, position) {
            $item.css({
                left: position.left - adjustment.left,
                top: position.top - adjustment.top
            });
        },
        onDrop: function ($item, container, _super, event) {

            $.post(window.location.href, {
                items: tree.sortable('serialize').get()[0] // This needs to return [0] for some reason..
            });

            _super($item, container);
        },
        serialize: function ($parent, $children, parentIsContainer) {

            var result = $.extend({}, $parent.data());

            if (parentIsContainer)
                return [$children];
            else if ($children[0]) {
                result.children = $children[0]; // This needs to return [0] for some reason..
            }

            delete result.subContainers;
            delete result.sortable;

            return result;
        }
    });

    /**
     * Hide initial items.
     */
    tree.find('li').each(function () {

        var collapsed = Cookies.getJSON('tree');

        if (typeof collapsed == 'undefined') {
            collapsed = {};
        }

        if (collapsed[$(this).data('id')] == true) {
            $(this).addClass('collapsed');
        }
    });

    /**
     * Toggle displaying children.
     */
    $('ul.tree.sortable .handle').click(function (e) {

        e.preventDefault();

        var item = $(this).closest('li');
        var collapsed = Cookies.getJSON('tree');

        item.toggleClass('collapsed');

        if (typeof collapsed == 'undefined') {
            collapsed = {};
        }

        collapsed[item.data('id')] = item.hasClass('collapsed');

        Cookies.set('tree', JSON.stringify(collapsed), {path: window.location.pathname});
    });
});
