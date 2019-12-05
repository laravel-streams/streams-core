<div class="tabs">
    
    <ul>
        @foreach ($section['tabs'] as $slug => $tab)
            <li>
                <button
                type="button"
                data-toggle="tab"
                class="{{ $loop->first ? 'active' : '' }}"
                data-target="#{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}-tab">
                    {{ $tab['title'] }}
            </button>
            </li>
        @endforeach
    </ul>

    <div class="tabs__content">
        @foreach ($section['tabs'] as $slug => $tab)
            <div id="{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}-tab" class="tabs__pane {{ $loop->first ? 'active' : '' }}">
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

</div>
