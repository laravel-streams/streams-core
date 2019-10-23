<div {{ html_attributes($fieldType->wrapperAttributes()) }}>

    <label class="control-label">
        {{ $fieldType->label }}

        @if ($fieldType->required)
            <span class="required">*</span>
        @endif

        @if ($fieldType->locale)
            @include('streams::form/partials/translations')
        @endif
    </label>

    @if ($fieldType->instructions)
        <p class="text-muted">{{ $fieldType->instructions }}</p>
    @endif
        
    @if ($fieldType->warning)
        <p class="help-block">
            <span class="text-warning">
                {{-- {{ icon('warning') }} --}}
                {{ $fieldType->warning }}
            </span>
        </p>
    @endif

    <div class="input-wrapper">
        {!! $fieldType->getInput(['form' => $form]) !!}
    </div>

</div>
