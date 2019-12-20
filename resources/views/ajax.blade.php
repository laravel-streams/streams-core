@yield('content')

@foreach (assets()->scripts("scripts.js", ["min"]) as $script)
    {!! $script !!}
@endforeach

{!! $template->includes->render('scripts') !!}

@foreach (assets()->styles("styles.css", ["min"]) as $style)
    {!! $style !!}
@endforeach
