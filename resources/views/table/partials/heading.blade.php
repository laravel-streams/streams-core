@if ($table->getOption('title') || $table->getOption('description'))
<div class="table__header">

    @if ($table->getOption('title'))
        <h4>
            {{ $table->getOption('title') }}

            @if ($table->getOption('description'))
            <small>
                {{ $table->getOption('description') }}
            </small>
            @endif
        </h4>
    @endif

</div>
@endif
