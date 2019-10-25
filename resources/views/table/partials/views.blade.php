@if ($table->hasViews())
    <div class="table__views">

        <nav>
            @foreach ($table->getViews() as $view)
                <a {{ html_attributes($view->getAttributes()) }}>
                    {{-- {{ $view->icon ? icon($view->icon)|raw }} --}}
                    {{ $view->getText() }}

                    @if ($view->getLabel())
                        <span class="tag tag-{{ $view->context }}">
                            {{ $view->label }}
                        </span>
                    @endif

                </a>
            @endforeach
        </nav>

    </div>
@endif
