@if ($table->hasOption('title') || $table->hasOption('description'))
<div class="card">

    @if ($table->hasOption('title'))
    <div class="card-block card-body">
        <h4 class="card-title">
            {{ trans($table->getOption('title')) }}

            @if ($table->hasOption('description'))
            <small>
                <br>{{ trans($table->getOption('description')) }}
            </small>
            @endif
        </h4>
    </div>
    @endif

</div>    
@endif
