$(function () {
    $('ul.tree.sortable').sortable({
        afterMove: function ($placeholder) {
            $placeholder.closest('ul.tree').find('.dragged').detach().insertBefore($placeholder);
        }
    });
});
