@if ($template->breadcrumbs->isNotEmpty())
	<ol class="breadcrumb">
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
@endif
