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
            {{ html_link(url()->current() . '?' . $header->getQueryString(), trans($header->getHeading() ?: 'Header: Heading')) }}

                @if ($header->getDirection() == 'asc')
                ASC
                {{-- {{ icon('sort-ascending', 'text-muted') }} --}}
                @elseif ($header->getDirection() == 'desc')
                DESC
                {{-- {{ icon('sort-descending', 'text-muted') }} --}}
                @else
                SRTBL
                {{-- {{ icon('sortable', 'text-muted') }} --}}
                @endif
            @else
            {{ trans($header->getHeading() ?: 'Header: Heading') }}
            @endif
        </th>
    @endforeach

    <th class="buttons">&nbsp;</th>
</tr>
</thead>
