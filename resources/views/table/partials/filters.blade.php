@if ($table->filters->isNotEmpty())
<v-container>
    <v-card>
        {!! form_open(['method' => 'get', 'id' => 'filters', 'url' => url()->full()]) !!}
            <input type="hidden" name="{{ $table->prefix('limit') }}" value="{{ $table->options->get('limit') }}">
            <input type="hidden" name="{{ $table->prefix('view') }}" value="{{ $table->views->active() }}">
            <input type="hidden" name="{{ $table->prefix('page') }}" value="1">
    
            @foreach ($table->filters as $filter)
                <div class="table__filter">
                    {!! $filter->getInput() !!}
                </div>
            @endforeach
    
            <button type="submit" class="button">
                {{-- {{ icon(table.options.filters.filter_icon ?: 'filter') }} --}}
                {{ trans('streams::button.filter') }}
            </button>
            
            <a href="{{ url()->current() }}" class="button">
                {{-- {{ icon(table.options.filters.clear_icon ? table.options.filters.clear_icon) }} --}}
                {{ trans('streams::button.clear') }}
            </a>
        {!! form_close() !!}
    </v-card>
</v-container>
@endif
