{{ assets("scripts.js", "streams::js/table/table.js") }}

@if ($table->hasActions())
    {{ assets("scripts.js", "streams::js/table/actions.js") }}
@endif

@if ($table->getOption('sortable'))
    {{ assets("scripts.js", "streams::js/table/sortable.js") }}
@endif

<div class="{{ $table->getOption('container_class', 'container-fluid') }}">

    @include('streams::table/partials/filters')
    @include('streams::table/partials/views')

    {{-- @include($table->getOption('heading', 'streams::table/partials/heading')); --}}

    {{-- {% if not table.rows.empty() %}
        {% block card %}
            <div class="card">

                {{ form_open({ 'url': url_full() }) }}
                <div class="table-stack">
                    <table
                            class="
                                {{ table.options.class ?: 'table' }}
                                {{ table.options.sortable ? 'table--sortable' }}
                                "
                            {{ table.options.sortable ? 'data-sortable' }}
                            {{ html_attributes(table.options.attributes) }}>

                        {{ view("streams::table/partials/header", {'table': table}) }}

                        {% block body %}
                            {{ view("streams::table/partials/body", {'table': table}) }}
                        {% endblock %}

                        {{ view("streams::table/partials/footer", {'table': table}) }}

                    </table>
                </div>
                {{ form_close() }}

            </div>
        {% endblock %}
    {% else %}

        {% block no_results %}
            <div class="card">
                <div class="card-block card-body">
                    {{ trans(table.options.get('no_results_message', 'streams::message.no_results')) }}
                </div>
            </div>
        {% endblock %}

    {% endif %} --}}

</div>
