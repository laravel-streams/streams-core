{{ assets('scripts.js', 'public::vendor/anomaly/core/js/form/form.js') }}
{{ assets('scripts.js', 'public::vendor/anomaly/core/js/form/tabs.js') }}
{{ assets('scripts.js', 'public::vendor/anomaly/core/js/form/lock.js') }}
{{ assets('scripts.js', 'public::vendor/anomaly/core/js/form/keyboard.js') }}
{{--{{ assets('scripts.js', 'public::vendor/anomaly/core/js/form/translations.js') }}--}}

@section('content')
    <div class="form__wrapper">

        {!! $form->open() !!}
        @include('streams::form/partials/controls')
        @include('streams::form/partials/heading')
        @include('streams::form/partials/layout')
        @include('streams::form/partials/controls')
        {!! $form->close() !!}

    </div>
@endsection
