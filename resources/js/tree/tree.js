$(function () {
    $('ul.tree.sortable').sortable({
        handle: '.handle',
        afterMove: function ($placeholder) {
            $placeholder.closest('ul.tree').find('.dragged').detach().insertBefore($placeholder);
        }
    });
});
