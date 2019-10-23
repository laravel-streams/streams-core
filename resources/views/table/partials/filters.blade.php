@if ($table->hasFilters())
    <div class="table__filters">
        {{ form_open(['method' => 'get', 'id' => 'filters', 'url' => url()->full(), 'class' => 'form-inline']) }}
        <input type="hidden" name="{{ $table->getOption('prefix') }}limit" value="{{ $table->getOption('limit') }}">
        <input type="hidden" name="{{ $table->getOption('prefix') }}view" value="{{ $table->getActiveView()->getSlug() }}">
        <input type="hidden" name="{{ $table->getOption('prefix') }}page" value="1">

        @foreach ($table->getFilters() as $filter)
            <div class="table__filter">
                {{ $filter->getInput() }}
            </div>
        @endforeach

        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            {{-- {{ icon(table.options.filters.filter_icon ?: 'filter') }} --}}
            {{ trans($table->getOption('filters.filter_text', 'streams::button.filter')) }}
        </button>
        <a href="{{ $filter->url() }}" class="hover:bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded">
            {{-- {{ icon(table.options.filters.clear_icon ? table.options.filters.clear_icon) }} --}}
            {{ trans($table->getOption('filters.filter_text', 'streams::button.clear')) }}
        </a>
        {{ form_close() }}
    </div>
@endif
