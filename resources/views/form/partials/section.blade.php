<div {{ html_attributes(array_get($section, 'attributes', [])) }} class="form__section">

    @include('streams::form/partials/header')

    @if (isset($section['fields']))
        @include('streams::form/partials/fields', ['fields' => $section['fields']])
    @elseif (isset($section['tabs']))
        @include('streams::form/partials/tabs', ['tabs' => $section['tabs']])
    @endif

</div>
