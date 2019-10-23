<div class="form__section" {{ html_attributes($section['attributes']) }}>

    @include('streams::form/partials/header')

    @if (isset($section['fields']))
        @include('streams::form/partials/fields',  ['fields' => $section['fields']])
    @elseif (isset($section['tabs']))
        @include('streams::form/partials/tabs',  ['tabs' => $section['tabs'], 'stacked' => array_get($section, 'stacked')])
    @elseif (isset($section['groups']))
        @include('streams::form/partials/groups', ['groups' => $section['groups']])
    @elseif (isset($section['groups']))
        @include('streams::form/partials/rows', ['rows' => $section['rows']])
    @endif

</div>
