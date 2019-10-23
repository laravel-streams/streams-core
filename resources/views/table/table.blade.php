{{ assets("scripts.js", "streams::js/table/table.js") }}

@if ($table->hasActions())
    {{ assets("scripts.js", "streams::js/table/actions.js") }}
@endif

@if ($table->getOption('sortable'))
    {{ assets("scripts.js", "streams::js/table/sortable.js") }}
@endif

<div class="table__wrapper" id="{{ $table->getOption('prefix') }}table-instance">

    @include('streams::table/partials/filters')
    @include('streams::table/partials/views')
    @include('streams::table/partials/heading')

    <div class="table__container">
        @if ($table->hasRows())
            {{ form_open(['url' => url()->full()]) }}
                <table {{ html_attributes($table->attributes()) }}>
                    @include('streams::table/partials/header')
                    @include('streams::table/partials/body')
                    @include('streams::table/partials/footer')
                </table>
            {{ form_close() }}
        @else
            {{ trans($table->getOption('no_results_message', 'streams::message.no_results')) }}
        @endif
    </div>

</div>
