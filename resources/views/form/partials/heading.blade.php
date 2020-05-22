@if ($form->options->has('title') || $form->options->has('description'))
<div class="form__heading">

    @if ($form->options->get('title'))
        <h4>
            {{ $form->options->get('title') }}

            @if ($form->options->get('description'))
            <small>
                {{ $form->options->get('description') }}
            </small>
            @endif
        </h4>
    @endif

</div>
@endif
