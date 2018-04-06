(function (window, document) {

    // Focus on the first filter input.
    let filters = Array.prototype.slice.call(
        document.querySelectorAll('#filters input')
    );

    filters.some(function (filter) {
        if (filter.type !== 'hidden') {
            filter.focus();
            return true;
        }
    });

})(window, document);
