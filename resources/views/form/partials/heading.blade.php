@if ($form->getOption('title') || $form->getOption('description'))
<div class="card">

    @if ($form->getOption('title'))
        <div class="card-block card-body">
            <h4 class="card-title">
                {{ trans($form->getOption('title')) }}

                @if ($form->getOption('description'))
                <small>
                    <br>{{ trans($form->getOption('description')) }}
                </small>
                @endif
            </h4>
        </div>
    @endif

</div>
@endif
