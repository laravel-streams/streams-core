$(document).ready(function () {
    $('table[data-sortable]').sortable({
        handle: '.handle',
        itemSelector: 'tr',
        itemPath: '> tbody',
        containerSelector: 'table',
        placeholder: '<tr class="placeholder"/>',
        afterMove: function ($placeholder, container, $closestItemOrContainer) {
            //$placeholder.text(Math.random());

            $placeholder.closest('table').find('.dragged').detach().insertBefore($placeholder);
        }
    });
});
