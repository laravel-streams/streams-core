$(function () {

    var grid = $('ul.grid.sortable').sortable({

        /**
         * Fires after moving a row
         *
         * @param      {String}  $placeholder  The placeholder
         */
        afterMove: function ($placeholder) {
            $placeholder.closest('ul.grid').find('.dragged')
                .detach().insertBefore($placeholder);
        },

        /**
         * Fires after item was dropped
         *
         * @param      {$}          $item      The item
         * @param      {Object}     container  The container
         * @param      {Function}   _super     The super
         * @param      {Event}      event      The event
         */
        onDrop: function ($item, container, _super, event) {

            $.post(window.location.href, {
                // This needs to return [0] for some reason..
                items: grid.sortable('serialize').get()[0]
            });

            _super($item, container);
        }
    });
});
