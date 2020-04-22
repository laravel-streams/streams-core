<cp-table :table="{{ $table->toJson() }}">

    <template v-slot:filters>
        @include('streams::table/partials/filters')
    </template>
    
    <template v-slot:heading>
        @include('streams::table/partials/heading')
    </template>

    <template v-slot:table>
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
    </template>
    
</cp-table>
