<thead class="o-table__head"> 
<tr>

    @if ($table->options->get('sortable'))
    <th class="table__handle"></th>
    @endif
    
    @if ($table->actions->isNotEmpty())
    <th class="table__checkbox">
        <v-checkbox/>
    </th>
    @endif

    @foreach ($table->columns as $column)
        <th {!! html_attributes($column->attr('attributes', [])) !!}>
            @if ($column->sortable)

                {!! html_link(url()->current() . '?order_by=' . $column->field . '&sort=' . ($column->direction == 'asc' ? 'desc' : 'asc'), $column->heading) !!}
                
                @if ($column->direction == 'asc')
                    {!! icon('sort-ascending') !!}
                @elseif ($column->direction == 'desc')
                    {!! icon('sort-descending') !!}
                @else
                    {!! icon('sortable') !!}
                @endif
            @else
                {{ $column->heading }}
            @endif
        </th>
    @endforeach

    <th></th>
</tr>
</thead>
