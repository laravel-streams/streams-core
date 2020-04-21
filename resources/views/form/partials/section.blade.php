<div {{ html_attributes(array_get($section, 'attributes', [])) }} class="form__section">

    @include('admin::form/partials/header')

    @include('admin::form/partials/fields', ['fields' => $section['fields']])

</div>
