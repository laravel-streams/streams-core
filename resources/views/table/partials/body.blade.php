<tbody>
    @foreach ($table->getRows() as $row)
        <tr {!! html_attributes($row->attributes()) !!}>

            @if ($table->getOption('sortable'))
            <td class="table__handle">
                {{ icon('fas fa-arrows') }}
                <input type="hidden" name="{{ $table->prefix('order[]') }}" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @if ($table->hasActions())
            <td class="table__checkbox">
                <input type="checkbox" name="{{ $table->prefix('id[]') }}" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @foreach ($row->getColumns() as $column)
                <td {{ html_attributes($column->attributes()) }}>
                    {!! $column->getValue() !!}
                </td>
            @endforeach

        <td class="table__buttons">
            {!! buttons($row->getButtons()) !!}
        </td>

    </tr>
    @endforeach
</tbody>
