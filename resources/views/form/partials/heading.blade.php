@if ($form->getOption('title') || $form->getOption('description'))
<div class="form__heading">

    @if ($form->getOption('title'))
        <h4>
                {{ $form->getOption('title') }}

                @if ($form->getOption('description'))
                <small>
                    {{ $form->getOption('description') }}
                </small>
                @endif
            </h4>
    @endif

</div>
@endif
