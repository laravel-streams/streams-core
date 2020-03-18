<cp-buttons>

    @foreach($buttons->primary() as $button)
    <cp-button :button="{{ $button->toJson() }}"></cp-button>
    @endforeach

    @if (($secondary = $buttons->secondary())->isNotEmpty())
    <div class="buttons__secondary">
        @foreach ($secondary as $button)
        <cp-button :button="{{ $button->toJson() }}"></cp-button>
        @endforeach    
    </div>
    @endif

</cp-buttons>
