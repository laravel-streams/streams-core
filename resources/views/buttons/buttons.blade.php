@foreach($buttons as $button)

    @if(!$button->isDropdown() && !$button->hasParent())
        {!! $button->open() !!}
            {{--{{ $button->getIcon() ? icon(button.icon)|raw }}--}}
            {{ trans($button->getText()) }}
        {!! $button->close() !!}
    @endif

    @if($button->isDropdown())
        {{--<div class="btn-group {{ button.dropup ? 'dropup' }}">--}}

            {{--{% if button.attributes.href %}--}}
                {{--<a class="btn btn-{{ button.size }} btn-{{ button.type }} {{ button.disabled ? 'disabled' }} {{ button.class }}" {{ button.disabled ? 'disabled' }} {{ html_attributes(button.attributes) }}>--}}
                    {{--{{ button.icon ? icon(button.icon)|raw }}--}}
                    {{--{{ trans(button.text)|raw }}--}}
                {{--</a>--}}

                {{--<a class="dropdown-toggle-split btn btn-{{ button.size }} btn-{{ button.type }} {{ button.disabled ? 'disabled' }}"--}}
                   {{--data-toggle="dropdown" {{ button.disabled ? 'disabled' }}>--}}
                    {{--{{ icon('fa fa-caret-down') }}--}}
                {{--</a>--}}
            {{--{% else %}--}}
                {{--<a class="dropdown-toggle btn btn-{{ button.size }} btn-{{ button.type }} {{ button.disabled ? 'disabled' }} {{ button.class }}" {{ button.disabled ? 'disabled' }}--}}
                   {{--data-toggle="dropdown" {{ html_attributes(button.attributes) }}>--}}
                    {{--{{ button.icon ? icon(button.icon)|raw }}--}}
                    {{--{{ trans(button.text)|raw }}--}}
                {{--</a>--}}
            {{--{% endif %}--}}

            {{--{# Render the actual dropdown links #}--}}
            {{--<ul class="dropdown-menu dropdown-menu-{{ button.position }}">--}}
                {{--{% for link in button.dropdown if button.enabled or button.enabled == null %}--}}
                    {{--{% if link.text %}--}}
                        {{--<li>--}}

                            {{--{# Render normal buttons as an anchor #}--}}
                            {{--{% if not link.attributes.name %}--}}
                                {{--<a class="dropdown-item" {{ html_attributes(link.attributes) }}>--}}
                                    {{--{{ link.icon ? icon(link.icon)|raw }}--}}
                                    {{--{{ trans(link.text)|raw }}--}}
                                {{--</a>--}}
                            {{--{% endif %}--}}

                            {{--{# Render normal buttons as a button #}--}}
                            {{--{% if link.attributes.name %}--}}
                                {{--<button class="dropdown-item" {{ html_attributes(link.attributes) }}>--}}
                                    {{--{{ link.icon ? icon(link.icon)|raw }}--}}
                                    {{--{{ trans(link.text)|raw }}--}}
                                {{--</button>--}}
                            {{--{% endif %}--}}

                        {{--</li>--}}
                    {{--{% else %}--}}
                        {{--<li class="dropdown-divider">--}}
                            {{--<hr>--}}
                        {{--</li>--}}
                    {{--{% endif %}--}}
                {{--{% endfor %}--}}
            {{--</ul>--}}
        {{--</div>--}}
    @endif

@endforeach
