<template>
    <div class="o-table">

        <slot name="filters">
            <cp-table-filters v-show="table.filters" :filters="table.filters"></cp-table-filters>
        </slot>

        <!-- <slot name="views">
            <cp-table-views v-show="table.views" :views="table.views"></cp-table-views>
        </slot> -->

        <slot name="heading">
            <cp-table-heading v-show="table.options.title || table.options.description" :options="table.options"></cp-table-heading>
        </slot>

        <slot name="table"></slot>

    </div>

</template>

<script>
export default {
    props: {
        table: Object,
    },
};
</script>
