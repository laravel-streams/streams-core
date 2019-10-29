<div class="tabs">
    <ul>
        @foreach ($tabs as $slug => $tab)
            <li>
                <a
                href="#{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}-tab"
                class="{{ $loop->first ? 'active' : '' }}">
                    {{ $tab['title'] }}
                </a>
            </li>
        @endforeach
    </ul>

    @foreach ($tabs as $slug => $tab)
        <section id="{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) ?: slug }}-tab">
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
        </section>
    @endforeach
</div>
