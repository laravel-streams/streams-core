$(function () {
    var grid = $('ul.grid.sortable').sortable({
        afterMove: function ($placeholder) {
            $placeholder.closest('ul.grid').find('.dragged').detach().insertBefore($placeholder);
        },
        onDrop: function ($item, container, _super, event) {

            $.post(window.location.href, {
                items: grid.sortable('serialize').get()[0] // This needs to return [0] for some reason..
            });

            _super($item, container);
        }
    });
});
