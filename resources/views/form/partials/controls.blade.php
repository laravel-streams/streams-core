<div class="form__controls">
    
    @if(!$form->options->get('read_only'))
        <div class="form__actions">
            {!! buttons($form->actions) !!}
        </div>
    @endif

    <div class="form__buttons">
        {!! buttons($form->buttons) !!}
    </div>
    
</div>
