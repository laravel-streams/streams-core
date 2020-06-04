@foreach ($fields as $field)
<div id="{{ $form->prefix('field-' . $field->slug) }}" class="form__fieldset">
    {!! $field->type()->render() !!}
</div>
@endforeach
