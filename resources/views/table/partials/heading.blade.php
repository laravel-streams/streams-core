@if ($table->options->get('title') || $table->options->get('description'))
<div>
    
    @if ($table->options->get('title'))
    <div class="title">
        {{ $table->options->get('title') }}
    </div>
    @endif

    @if ($table->options->get('description'))
    <div class="subtitle-1">
        {{ $table->options->get('description') }}
    </div>
    @endif

</div>
@endif
