<div class="form__section" {{ html_attributes($section['attributes']) }}>

    @include('streams::form/partials/header')

    @if (isset($section['fields']))
        @include('streams::form/partials/fields',  ['fields' => $section['fields']])
    @elseif (isset($section['tabs']))
        @include('streams::form/partials/tabs',  ['tabs' => $section['tabs'], 'stacked' => array_get($section, 'stacked')])
    @endif

</div>
