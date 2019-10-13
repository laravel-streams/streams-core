{{ assets("scripts.js", "streams::js/table/table.js") }}

@if ($table->hasActions())
    {{ assets("scripts.js", "streams::js/table/actions.js") }}
@endif

@if ($table->getOption('sortable'))
    {{ assets("scripts.js", "streams::js/table/sortable.js") }}
@endif

<div class="{{ $table->getOption('container_class', 'container-fluid') }}">

    @include('streams::table/partials/filters')
    @include('streams::table/partials/views')

    @include($table->getOption('heading', 'streams::table/partials/heading'))

    @if ($table->hasRows())
        <div class="card">

            {{ form_open(['url' => url()->full()]) }}
            <div class="table-stack">
                <table {{ html_attributes($table->getOption('attributes', [])) }}>
                    @include('streams::table/partials/header')
                    @include('streams::table/partials/body')
                    @include('streams::table/partials/footer')
                </table>
            </div>
            {{ form_close() }}

        </div>
    @else
        @section('no_results')
            <div class="card">
                <div class="card-block card-body">
                    {{ trans($table->getOption('no_results_message', 'streams::message.no_results')) }}
                </div>
            </div>
        @endsection
    @endif

</div>
