{{--{{ asset_add('scripts.js', 'streams::js/form/form.js') }}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/keyboard.js') }}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/translations.js') }}--}}

{{--{% if not form.options.locked %}--}}
{{--{{ asset_add('scripts.js', 'streams::js/form/lock.js') }}--}}
{{--{% endif %}--}}

@section('content')
    <div class="container mx-auto">

        {!! $form->open([
            'class' => 'form ' . $form->getOption('class'),
        ]) !!}

        @include('streams::form/partials/controls', ['position' => 'top'])
        @include('streams::form/partials/heading')
        @include('streams::form/partials/layout')
        {!! $form->fields->email->input !!}
        {!! $form->fields->password->input !!}
        @include('streams::form/partials/controls', ['position' => 'bottom'])

        {!! $form->close() !!}

    </div>
@endsection
