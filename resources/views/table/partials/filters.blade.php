@if ($table->hasFilters())
    <div class="card card-container">
        {{ form_open(['method' => 'get', 'id' => 'filters', 'url' => url()->full(), 'class' => 'form-inline']) }}
        <input type="hidden" name="{{ $table->getOption('prefix') }}limit" value="{{ $table->getOption('limit') }}">
        <input type="hidden" name="{{ $table->getOption('prefix') }}view" value="{{ $table->getActiveView()->getSlug() }}">
        <input type="hidden" name="{{ $table->getOption('prefix') }}page" value="1">

        @foreach ($table->getFilters() as $filter)
            <div class="form-group">
                {{ $filter->getInput() }}
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">
            {{-- {{ icon(table.options.filters.filter_icon ?: 'filter') }} --}}
            {{ trans($table->getOption('filters.filter_text', 'streams::button.filter')) }}
        </button>
        <a href="{{ $filter->url() }}" class="btn btn-inverse">
            {{-- {{ icon(table.options.filters.clear_icon ? table.options.filters.clear_icon) }} --}}
            {{ trans($table->getOption('filters.filter_text', 'streams::button.clear')) }}
        </a>
        {{ form_close() }}
    </div>
@endif
