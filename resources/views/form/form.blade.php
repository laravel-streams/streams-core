<cp-form :form="{{ $form->toJson() }}"></cp-form>

@section('content')
    <div class="form__wrapper">

        {!! $form->open() !!}
        @include('streams::form/partials/heading')
        @include('streams::form/partials/layout')
        @include('streams::form/partials/controls')
        {!! $form->close() !!}

    </div>
@endsection
