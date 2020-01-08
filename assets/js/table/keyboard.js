/**
 * Focus on the first input.
 */
let filters = Array.prototype.slice.call(
    document.querySelectorAll('.table__filter input')
);

filters.some(function (filter) {
    if (filter.type !== 'hidden') {
        filter.focus();
        return true;
    }
});
