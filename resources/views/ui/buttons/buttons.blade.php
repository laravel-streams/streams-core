{{-- <cp-buttons :buttons="{{ $buttons->toJson() }}"></cp-buttons> --}}
@foreach ($buttons as $button)

{!! $button->open([
    "href" => $button->attr("attributes.href"),
    "class" => "uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1"
]) !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ $button->text }}
{!! $button->close() !!}
    
@endforeach
