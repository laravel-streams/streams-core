<template>
    <div class="o-table">

        <cp-table-filters v-show="table.filters" :filters="table.filters"></cp-table-filters>
        <cp-table-views v-show="table.views" :views="table.views"></cp-table-views>
        <cp-table-heading v-show="table.options.title || table.options.description" :options="table.options"></cp-table-heading>

        <slot></slot>

    </div>

</template>

<script>
export default {
    props: {
        table: Object,
    },
};
</script>
