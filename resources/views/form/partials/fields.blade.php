@foreach ($fields as $field)
    @if ($form->fields->translations($field)->isNotEmpty())
        <div id="{{ $form->prefix('field-' . $field) }}" class="form__fieldset">
            @foreach ($form->fields->translations($field) as $field)
                {!! $field->render(['form' => $form]) !!}
            @endforeach        
        </div>
    @endif
@endforeach
