<tbody>
    @foreach ($table->getRows() as $row)
        <tr id="{{ $row->getKey() }}">

            @if ($table->getOption('sortable'))
            <td>
                {{-- {{ icon('fa fa-arrows handle') }} --}}
                <input type="hidden" name="{{ $table->getOption('prefix') }}order[]" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @if ($table->hasActions())
            <td>
                <input type="checkbox" data-toggle="action" name="{{ $table->getOption('prefix') }}id[]" value="{{ $row->getKey() }}"/>
            </td>
            @endif

            @foreach ($row->getColumns() as $column)
                <td {{ html_attributes($column->getAttributes()) }}>
                    {!! $column->getValue() !!}
                </td>
            @endforeach

        <td class="text-right">
            {!! buttons($row->getButtons()) !!}
        </td>

    </tr>
    @endforeach
</tbody>
