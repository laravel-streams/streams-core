@extends($template->get('layout', 'theme::layouts/blank'))

@section('content')
    {!! $content !!}
@endsection

@include('theme::partials/assets')
