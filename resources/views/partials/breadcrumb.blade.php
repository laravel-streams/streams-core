@if ($template->breadcrumbs->isNotEmpty())
<nav class="breadcrumb">
    <ol>
		@foreach ($template->breadcrumbs as $breadcrumb => $url)
        @if ($loop->last)
            <li>
                <span>{{ trans($breadcrumb) }}</span>
            </li>
        @else
            <li>
                <a href="{!! $url !!}">{{ trans($breadcrumb) }}</a>
            </li>
        @endif
        @endforeach
    </ol>	
</nav>
@endif
