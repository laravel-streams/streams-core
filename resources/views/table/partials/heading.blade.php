@if ($table->getOption('title') || $table->getOption('description'))
<div class="card">

    @if ($table->getOption('title'))
        <div class="card-block card-body">
            <h4 class="card-title">
                {{ trans($table->getOption('title')) }}

                @if ($table->getOption('description'))
                <small>
                    <br>{{ trans($table->getOption('description')) }}
                </small>
                @endif
            </h4>
        </div>
    @endif

</div>
@endif
