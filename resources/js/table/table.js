$(function () {

    // Focus on the first filter input.
    $('#filters').find('input:visible').first().focus();
});

let cpTable = new Vue({
    el: 'table.table',
    name: 'cpTable',

    data: {
        selected: [],
    },

    methods: {
        rowClick (e, id) {
            if (e.shiftKey) {
                this.selectInterval(this.selected[0], id);
                return;
            }
            this.selectOne(id);
        },

        selectInterval (start, end) {
            let fromId = start < end ? start : end;
            let toId = start < end ? end : start;
            this.selected = [];
            for (let i = fromId; i <= toId; i++) {
                this.selected.push(i);
            }
        },

        selectOne (id) {
            this.selected = this.isSelected(id) ? [] : [id];
        },

        isSelected (id) {
            return this.selected.includes(id);
        }
    },
});
