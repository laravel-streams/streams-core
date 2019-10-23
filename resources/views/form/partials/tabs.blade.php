<div class="form__section--tabs">
    <ul>
        @foreach ($tabs as $slug => $tab)
            <li>
                <a href="#tab-{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}">
                    {{ $tab['title'] }}
                </a>
            </li>
        @endforeach
    </ul>

    @foreach ($tabs as $slug => $tab)
        <div class="section__tab" id="{{ $form->getOption('prefix') }} }}{{ array_get($tab, 'slug', $slug) ?: slug }}-tab">
            @if (isset($tab['view']))
                @include($tab['view'])
            @elseif (isset($tab['html']))
                {!! parse($tab['html']) !!}
            @else
                @if (isset($tab['fields']))
                    @include('streams::form/partials/fields', ['fields' => $tab['fields']])
                @else
                    {{ trans('streams::message.no_fields_available') }}
                @endif
            @endif
        </div>
    @endforeach
</div>
