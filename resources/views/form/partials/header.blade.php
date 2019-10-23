@if (isset($section['title']))
    <div class="form__section_header">
        <h5>
            {{-- {{ section.icon ? icon(section.icon) }} --}}

            {{ $section['title'] }}

            @if (isset($section['description']))
                <br>

                <small>
                    {{ trans(section.description)|raw }}
                </small>
            @endif
        </h5>
    </div>
@endif
