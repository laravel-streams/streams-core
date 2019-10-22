<tbody>
    @foreach ($table->getRows() as $row)
    <tr id="{{ $row->getKey() }}" class="{{ $row->getClass() }}">

        @if ($table->getOption('sortable'))
            <td>
                {{-- {{ icon('fa fa-arrows handle') }} --}}
                <input type="hidden" name="{{ $row->getTable()->getOption('prefix') }}order[]" value="{{ $row->getKey() }}"/>
            </td>
        @endif

        @if ($table->hasActions())
            <td>
                <input type="checkbox" data-toggle="action" name="{{ $row->getTable()->getOption('prefix') }}id[]" value="{{ $row->getKey() }}"/>
            </td>
        @endif

        @foreach ($row->getColumns() as $column)
            <td data-title="{{ $column->getHeading() ? trans($column->getHeading()) : '$column->getHeading()' }}"
                class="{{ $column->getClass() }}" {{ html_attributes($column->getAttributes()) }}>
                {!! $column->getValue() !!}
            </td>
        @endforeach

        <td class="text-lg-right">
            {{ buttons($row->getButtons()) }}
        </td>

    </tr>
    @endforeach
</tbody>
