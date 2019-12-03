@foreach($buttons as $button)
    {!! $button->open() !!}
        {!! $button->icon() !!}
        {{ $button->getText() }}
    {!! $button->close() !!}
@endforeach
