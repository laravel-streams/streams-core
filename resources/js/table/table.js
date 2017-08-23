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

    computed: {
        isSingleSelected () { return this.selected.length === 1 },
        isMultiSelected () { return this.selected.length > 1 },
    },

    methods: {
        rowClick (e, id) {
            if (this.isMultiSelected) {
                if (this.isSelected(id)) {
                    return this.selected.splice(this.selected.indexOf(id), 1);
                }
                return this.selected.push(id);
            }
            if (this.isSingleSelected) {
                if (e.shiftKey && !this.isSelected(id)) {
                    return this.selectInterval(this.selected[0], id);
                }
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
