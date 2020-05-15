<tfoot>
    @if ($table->actions->isNotEmpty() || $table->pagination)
        <tr>
        <th colspan="100%">
            <div class="table__footer">
                <div class="table__actions">
                    {!! buttons($table->actions) !!}
                </div>

                @if ($table->pagination)
                    <div class="table__limit">

                        <select onchange="window.location=this.value;">
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 5 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 5] + request()->query()) }}">
                                5 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 10 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 10] + request()->query()) }}">
                                10 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 15 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 15] + request()->query()) }}">
                                15 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 25 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 25] + request()->query()) }}">
                                25 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 50 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 50] + request()->query()) }}">
                                50 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 75 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 75] + request()->query()) }}">
                                75 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 100 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 100] + request()->query()) }}">
                                100 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 150 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 150] + request()->query()) }}">
                                150 {{ trans('streams::message.results') }}</option>
                            <option {{ $table->options->get('limit', $table->pagination->perPage()) == 10000 ? 'selected' : '' }}
                                    value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => 10000] + request()->query()) }}">
                                {{ trans('streams::message.show_all') }}</option>
                        </select>
                    </div>

                    <div class="table__pagination">
                        {{ $table->pagination->links() }}
                    </div>
                @endif
            </div>
        </th>
    </tr>
    @endif

    @if ($table->options->get('total_results'))
    <tr>
        <td colspan="100%">
            <small class="table__total">
                {{ $table->pagination->total_results }} {{ trans('streams::message.results') }}
            </small>
        </td>
    </tr>
    @endif
</tfoot>
