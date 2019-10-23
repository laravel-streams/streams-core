<ul class="nav nav-sections">
    @foreach ($tabs as $slug => $tab)
        <li class="nav-item">
            <a href="#tab-{{ $form->getOption('prefix') }}{{ array_get($tab, 'slug', $slug) }}" data-toggle="tab" class="nav-link">
                {{ trans($tab['title']) }}
            </a>
        </li>
    @endforeach
</ul>

<div class="card-block card-body">
    @foreach ($tabs as $slug => $tab)
        <div class="tab__pane tab-pane" id="tab-{{ $form->getOption('prefix') }} }}{{ array_get($tab, 'slug', $slug) ?: slug }}">
            @if (isset($tab['view']))
                $tab['view']
            @elseif (isset($tab['html']))
                {!! parse($tab['html']) !!}
            @elseif (isset($tab['rows']))
                @include('streams::form/partials/rows', ['rows' => $tab['rows']])
            @else
                @if (isset($tab['fields']))
                    @include('streams::form/partials/fields', ['fields' => $tab['fields']])
                @else
                    <div class="form-group">
                        {{ trans('streams::message.no_fields_available') }}
                    </div>
                @endif
            @endif
        </div>
    @endforeach
</div>
