<div class="tabs">
    <ul class="nav nav-tabs">
        @foreach ($tabs as $slug => $tab)
            <li class="nav-item">
                <a
                data-toggle="tab"
                href="#{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}-tab"
                class="nav-link {{ $loop->first ? 'active' : '' }}">
                    {{ $tab['title'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">

        @foreach ($tabs as $slug => $tab)
        <div id="{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) ?: slug }}-tab" class="tab-pane {{ $loop->first ? 'active' : '' }}">
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
