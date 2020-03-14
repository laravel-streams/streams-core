<template>
    <!-- {{ assets('scripts.js', 'public::vendor/anomaly/core/js/table/table.js') }} -->

    <div class="o-table" id="table-instance">

        <!-- @include('admin::table/partials/filters')
        @include('admin::table/partials/views')
        @include('admin::table/partials/heading') -->

        <div class="table__container">
            <!-- @if ($table->hasRows()) -->
                <!-- {!! form_open(['url' => url()->full()]) !!} -->
                    <!-- <table {!! html_attributes($table->attributes()) !!}> -->
                    <table>
                        <tbody>
                            <tr v-for="(row, index) in table.rows" :key="index">Test</tr>
                        </tbody>
                    </table>
                <!-- {!! form_close() !!} -->
            <!-- @else
                {{ trans('streams::message.no_results') }}
            @endif -->
        </div>

    </div>

</template>

<script>
export default {
    props: {
        table: Object,
    },
    ready() {
        console.log("Table ready.");
    }
};
</script>
