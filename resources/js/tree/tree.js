$(function () {
    $('ul.tree.sortable').sortable({
        handle: '.handle',
        afterMove: function ($placeholder) {

            /*$placeholder.closest('table').find('button.reorder').removeClass('disabled');

            $placeholder.closest('table').find('.dragged').detach().insertBefore($placeholder);*/
        }
    });
});
