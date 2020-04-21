@if ($table->hasViews())
<v-container>
    <nav>
        @foreach ($table->getViews() as $view)
            <a {!! html_attributes($view->attributes()) !!}>
                {!! $view->icon() !!}
                {{ $view->getText() }}

                @if ($view->getLabel())
                    <span class="{{ $view->getContext() }}">
                        {{ $view->getLabel() }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</v-container>
@endif
