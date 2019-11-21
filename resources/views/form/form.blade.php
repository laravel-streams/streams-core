{{ assets('scripts.js', 'streams::js/form/form.js') }}
{{-- {{ assets('scripts.js', 'streams::js/form/lock.js') }} --}}
{{ assets('scripts.js', 'streams::js/form/keyboard.js') }}
{{--{{ assets('scripts.js', 'streams::js/form/translations.js') }}--}}

@section('content')
    <div class="form__wrapper">

        {!! $form->open(['class' => 'form']) !!}

        @include('streams::form/partials/controls')
        @include('streams::form/partials/heading')
        @include('streams::form/partials/layout')
        @include('streams::form/partials/controls')

        {!! $form->close() !!}

    </div>
@endsection
