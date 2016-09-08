$(document).ready(function() {
    $('table[data-sortable]').sortable({
        handle: '.handle',
        itemSelector: 'tr',
        itemPath: '> tbody',
        containerSelector: 'table',
        placeholder: '<tr class="placeholder"/>',
        afterMove: function($placeholder) {

            $placeholder
                .closest('table')
                .find('button.reorder')
                .removeClass('disabled')
                .removeAttr('disabled');

            $placeholder.closest('table').find('.dragged').detach().insertBefore($placeholder);
        }
    });
});
