@if ($form->fields->isEmpty())
    <div class="card">
        <div class="card-block card-body">
            {{ trans("streams::message.no_fields_available") }}
        </div>
    </div>
@else
    @if ($form->sections->isnotEmpty())
        @foreach ($form->sections as $section)
            @if (isset($section['view']))
                @include($section['view'])
            @elseif (isset($section['html']))
                {!! $section['html'] !!}
            @else
                @include('streams::form/partials/section')
            @endif
        @endforeach
    @else
    Default
    {{-- {% include "streams::form/partials/default" %} --}}
    @endif
    
@endif
