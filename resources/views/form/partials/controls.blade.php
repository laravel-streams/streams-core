<div class="controls {{ $position }} {{ $form->getOption('section_class', 'card') }}">
    <div class="card-block card-body">

        @if(!$form->getOption('read_only'))
            <div class="form__actions actions">
                {{ buttons($form->getActions()) }}
            </div>
        @endif

        <div class="form__buttons buttons">
            {{ buttons($form->getButtons()) }}
        </div>

    </div>
</div>
