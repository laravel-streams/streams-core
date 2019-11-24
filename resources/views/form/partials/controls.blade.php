<div class="form__controls">
    
    @if(!$form->getOption('read_only'))
        <div class="form__actions">
            {!! buttons($form->getActions()) !!}
        </div>
    @endif

    <div class="form__buttons">
        {!! buttons($form->getButtons()) !!}
    </div>
    
</div>
