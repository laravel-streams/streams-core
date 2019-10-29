{{--{{ asset_add('scripts.js', 'streams::js/form/form.js') }}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/keyboard.js') }}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/translations.js') }}--}}

{{--{% if not form.options.locked %}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/lock.js') }}--}}
{{--{% endif %}--}}

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
