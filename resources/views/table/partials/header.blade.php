<thead>
<tr>

    @if ($table->getOption('sortable'))
    <th class="table__handle"></th>
    @endif
    
    @if ($table->hasActions())
    <th class="table__checkbox">
        <input type="checkbox">
    </th>
    @endif

    @foreach ($table->getHeaders() as $header)
        <th {!! html_attributes($header->attributes()) !!}>
            @if ($header->isSortable())
            
                {!! html_link(url()->current() . '?' . $header->getQueryString(), $header->getHeading()) !!}
                
                @if ($header->getDirection() == 'asc')
                    {!! icon('sort-ascending') !!}
                @elseif ($header->getDirection() == 'desc')
                    {!! icon('sort-descending') !!}
                @else
                    {!! icon('sortable') !!}
                @endif
            @else
                {{ $header->getHeading() }}
            @endif
        </th>
    @endforeach

    <th></th>
</tr>
</thead>
