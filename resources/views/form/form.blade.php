<cp-form :form="{{ $form->toJson() }}"></cp-form>

{{-- {{ assets('scripts.js', 'public::vendor/anomaly/core/js/form.js') }} --}}

@section('content')
    <div class="form__wrapper">

        {!! $form->open() !!}
        @include('admin::form/partials/heading')
        @include('admin::form/partials/layout')
        @include('admin::form/partials/controls')
        {!! $form->close() !!}

    </div>
@endsection
