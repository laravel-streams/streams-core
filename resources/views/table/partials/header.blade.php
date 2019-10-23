<thead>
<tr>

    @if ($table->getOption('sortable'))
    <th style="width: 30px;">&nbsp;</th>
    @endif
    
    @if ($table->hasActions())
    <th style="width: 30px;">
        <input data-toggle="all" type="checkbox">
    </th>
    @endif

    @foreach ($table->getHeaders() as $header)
        <th>
            @if ($header->isSortable())
                {{ html_link(url()->current() . '?' . $header->getQueryString(), $header->getHeading()) }}
                
                @if ($header->getDirection() == 'asc')
                    {{-- {{ icon('sort-ascending', 'text-muted') }} --}}
                @elseif ($header->getDirection() == 'desc')
                    {{-- {{ icon('sort-descending', 'text-muted') }} --}}
                @else
                    {{-- {{ icon('sortable', 'text-muted') }} --}}
                @endif
            @else
                {{ $header->getHeading() }}
            @endif
        </th>
    @endforeach

    <th>&nbsp;</th>
</tr>
</thead>
