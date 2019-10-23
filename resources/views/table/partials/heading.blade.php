@if ($table->getOption('title') || $table->getOption('description'))
<div class="table__heading">

    @if ($table->getOption('title'))
        <h4>
            {{ trans($table->getOption('title')) }}

            @if ($table->getOption('description'))
            <small>
                <br>{{ trans($table->getOption('description')) }}
            </small>
            @endif
        </h4>
    @endif

</div>
@endif
