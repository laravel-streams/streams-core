<tbody class="o-table__body">
    @foreach ($table->getRows() as $row)
        <tr {!! html_attributes($row->attr('attributes', [])) !!}>

            @if ($table->getOption('sortable'))
            <td class="o-table__column">
                {{ icon('fas fa-arrows') }}
                <input type="hidden" name="{{ $table->prefix('order[]') }}" value="{{ $row->key }}"/>
            </td>
            @endif

            @if ($table->hasActions())
            <td class="o-table__column">
                <v-checkbox name="{{ $table->prefix('id[]') }}" value="{{ $row->key }}"/>
            </td>
            @endif

            @foreach ($row->columns as $column)
                <td {{ html_attributes($column->attr('attributes', [])) }}>
                    {!! $column->getValue() !!}
                </td>
            @endforeach

        <td class="o-table__column o-table__column--actions">
            {!! buttons($row->buttons) !!}
        </td>

    </tr>
    @endforeach
</tbody>
