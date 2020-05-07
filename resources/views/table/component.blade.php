<section>

    @include('streams::table/partials/filters')
    @include('streams::table/partials/heading')

    <div class="table__container">
        @if ($table->hasRows())
            {!! form_open(['url' => url()->full()]) !!}
                <table {!! html_attributes($table->attributes()) !!}>
                    @include('streams::table/partials/header')
                    @include('streams::table/partials/body')
                    @include('streams::table/partials/footer')
                </table>
            {!! form_close() !!}
        @else
            {{ trans('streams::message.no_results') }}
        @endif
    </div>
    
</section>
