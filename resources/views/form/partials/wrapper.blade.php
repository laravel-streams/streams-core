<div {!! html_attributes($fieldType->wrapperAttributes()) !!}>

    <label for="{{ $fieldType->getInputName() }}">
        {{ $fieldType->getLabel() }}

        @if ($fieldType->required)
            <span class="field__required">*</span>
        @endif

        @if ($fieldType->locale)
            @include('streams::form/partials/translations')
        @endif
    </label>

    @if ($fieldType->instructions)
        <div class="field__instructions">{{ $fieldType->instructions }}</div>
    @endif
        
    @if ($fieldType->warning)
        <div class="field__warning">
            {!! icon('warning') !!}
            {{ $fieldType->warning }}
        </p>
    @endif

    <div class="field__input">
        {!! $fieldType->getInput(['form' => isset($form) ? $form : null]) !!}
    </div>

</div>
