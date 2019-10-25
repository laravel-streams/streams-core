@if (isset($section['title']))
    <div class="form__section_header">
        <h5>
            {{-- {{ section.icon ? icon(section.icon) }} --}}

            {{ $section['title'] }}

            @if (isset($section['description']))
                <br>

                <small>
                    {{ $section['description'] }}
                </small>
            @endif
        </h5>
    </div>
@endif
