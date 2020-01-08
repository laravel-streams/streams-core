@foreach($buttons->primary() as $button)
    {!! $button->open() !!}
        {!! $button->icon() !!}
        {{ $button->getText() }}
    {!! $button->close() !!}
@endforeach

@if (($secondary = $buttons->secondary())->isNotEmpty())
    <div class="dropdown">
        <button type="button"><i class="fa fa-ellipsis-h"></i></button>
        <div>
            @foreach ($secondary as $button)
            {!! $button->open() !!}
                {!! $button->icon() !!}
                {{ $button->getText() }}
            {!! $button->close() !!}
            @endforeach
        </div>
    </div>
@endif
