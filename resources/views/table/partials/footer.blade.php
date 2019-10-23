<tfoot>
    @if ($table->hasActions() || $table->getData()->get('pagination')['links'])
        <tr>
        <th colspan="100%" style="padding: 10px;">

            <div class="pull-left actions table__actions">
                {{ buttons($table->getActions()) }}
            </div>

            @if ($table->getData()->get('pagination')['links'])
                <div class="pull-right">

                    <select onchange="window.location=this.value;">
                        <option {{ $table->getOption('limit') == 5 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 5] + request()->query()) }}">
                            5 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 10 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 10] + request()->query()) }}">
                            10 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 15 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 15] + request()->query()) }}">
                            15 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 25 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 25] + request()->query()) }}">
                            25 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 50 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 50] + request()->query()) }}">
                            50 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 75 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 75] + request()->query()) }}">
                            75 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 100 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 100] + request()->query()) }}">
                            100 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 150 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 150] + request()->query()) }}">
                            150 {{ trans('streams::message.results') }}</option>
                        <option {{ $table->getOption('limit') == 10000 ? 'selected' : '' }}
                                value="{{ url()->current() }}?{{ http_build_query([($table->getOption('prefix') . 'limit') => 10000] + request()->query()) }}">
                            {{ trans('streams::message.show_all') }}</option>
                    </select>

                    {{ $table->getData()->get('pagination')['links'] }}
                </div>
            @endif

            <div style="clear: both;"></div>

        </th>
    </tr>
    @endif

    @if ($table->getOption('total_results'))
    <tr>
    <td colspan="100%">
        <small class="float-right">
            {{ $table->getOption('total_results') }} {{ trans('streams::message.results') }}
        </small>
    </td>
</tr>
    @endif
</tfoot>
