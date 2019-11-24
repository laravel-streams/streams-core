@foreach($buttons as $button)

    @if(!$button->isDropdown() && !$button->hasParent())
        {!! $button->open() !!}
            {!! $button->icon() !!}
            {!! $button->getText() !!}
        {!! $button->close() !!}
    @endif

    @if($button->isDropdown())
        <nav>
            @if ($button->hasAttribute('href'))
                <a {{ html_attributes($button->attributes()) }}>
                     {!! $button->icon() !!} 
                    {{ $button->getText() }}
                </a>

                <button>
                    {!! icon('fa fa-caret-down') !!}
                </button>
            @else
                <a {{ html_attributes($button->attributes()) }}>
                     {!! $button->icon() !!} 
                    {{ $button->getText() }}
                </a>
            @endif
            
            {{-- <ul class="dropdown-menu dropdown-menu-{{ button.position }}">
                {% for link in button.dropdown if button.enabled or button.enabled == null %}
                    {% if link.text %}
                        <li>

                            {# Render normal buttons as an anchor #}
                            {% if not link.attributes.name %}
                                <a class="dropdown-item" {{ html_attributes(link.attributes) }}>
                                     {!! $link->icon() !!} 
                                    {{ trans(link.text)|raw }}
                                </a>
                            {% endif %}

                            {# Render normal buttons as a button #}
                            {% if link.attributes.name %}
                                <button class="dropdown-item" {{ html_attributes(link.attributes) }}>
                                     {!! $link->icon() !!} 
                                    {{ trans(link.text)|raw }}
                                </button>
                            {% endif %}

                        </li>
                    {% else %}
                        <li class="dropdown-navider">
                            <hr>
                        </li>
                    {% endif %}
                {% endfor %}
            </ul> --}}
        </nav>
    @endif

@endforeach
