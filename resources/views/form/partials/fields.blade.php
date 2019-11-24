<div class="form__fields">
@foreach ($fields as $field)
    @if ($form->fields->translations($field)->isNotEmpty())
        <div class="field__group {{ $field }}">
            @foreach ($form->fields->translations($field) as $field)
                {!! $field->render(['form' => $form]) !!}
            @endforeach        
        </div>
    @endif
@endforeach
</div>
