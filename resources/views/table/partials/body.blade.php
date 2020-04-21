<tbody class="o-table__body">
    @foreach ($table->getRows() as $row)
        <tr {!! html_attributes($row->attributes()) !!}>

            @if ($table->getOption('sortable'))
            <td class="o-table__column">
                {{ icon('fas fa-arrows') }}
                <input type="hidden" name="{{ $table->prefix('order[]') }}" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @if ($table->hasActions())
            <td class="o-table__column">
                <v-checkbox name="{{ $table->prefix('id[]') }}" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @foreach ($row->getColumns() as $column)
                <td {{ html_attributes($column->attributes()) }}>
                    {!! $column->getValue() !!}
                </td>
            @endforeach

        <td class="o-table__column o-table__column--actions">
            {!! buttons($row->getButtons()) !!}
        </td>

    </tr>
    @endforeach
</tbody>
