{{ assets("scripts.js", "streams::js/table/table.js") }}
{{ assets("scripts.js", "streams::js/table/actions.js") }}
{{ assets("scripts.js", "streams::js/table/sortable.js") }}
{{-- Combine these into single table.js --}}

<div class="table__wrapper" id="{{ $table->getOption('prefix') }}table-instance">

    @include('streams::table/partials/filters')
    @include('streams::table/partials/views')
    @include('streams::table/partials/heading')

    <div class="table__container">
        @if ($table->hasRows())
            {!! form_open(['url' => url()->full()]) !!}
                <table {!! html_attributes($table->attributes(['class' => 'table'])) !!}>
                    @include('streams::table/partials/header')
                    @include('streams::table/partials/body')
                    @include('streams::table/partials/footer')
                </table>
            {!! form_close() !!}
        @else
            {{ trans('streams::message.no_results') }}
        @endif
    </div>

</div>
