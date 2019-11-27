<div class="section">

    @include('streams::form/partials/header')

    @include('streams::form/partials/fields', ['fields' => $form->fields->base()->pluck('field_name')->all()])
    
</div>
