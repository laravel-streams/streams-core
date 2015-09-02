$(function () {
    var tree = $('ul.tree.sortable').sortable({
        handle: '.handle',
        onDragStart: function ($item, container, _super, event) {
            $item.css({
                height: $item.outerHeight(),
                width: $item.outerWidth()
            });

            $item.addClass('dragged');

            $('body').addClass('dragging');
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

            return result
        }
    });
});
