<div {{ html_attributes(\Illuminate\Support\Arr::get($section, 'attributes', [])) }} class="form__section">

    @include('streams::form/partials/header')

    @include('streams::form/partials/fields', ['fields' => $section['fields']])

</div>
