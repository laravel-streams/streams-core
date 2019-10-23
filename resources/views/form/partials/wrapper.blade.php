<div {{ html_attributes($fieldType->wrapperAttributes()) }}>

    <label>
        {{ $fieldType->getLabel() }}

        @if ($fieldType->required)
            <span class="field__required">*</span>
        @endif

        @if ($fieldType->locale)
            @include('streams::form/partials/translations')
        @endif
    </label>

    @if ($fieldType->instructions)
        <div class="field__instructions">{{ $fieldType->instructions }}</p>
    @endif
        
    @if ($fieldType->warning)
        <div class="field__help">
            {{-- {{ icon('warning') }} --}}
            {{ $fieldType->warning }}
        </p>
    @endif

    <div class="field__input">
        {!! $fieldType->getInput(['form' => $form]) !!}
    </div>

</div>
