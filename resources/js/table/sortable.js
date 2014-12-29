$(document).ready(function () {

    $('table.sortable').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        handle: '.handle',
        placeholder: '<tr class="placeholder"/>'
    });
});
