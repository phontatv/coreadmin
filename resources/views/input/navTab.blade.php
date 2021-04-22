@php
	$active = isset($active) ? $active : "";
@endphp
<li role="presentation" class="{{ $active }}">
	<a href="#{{ $id }}" aria-controls="{{ $id }}" role="tab" data-toggle="tab">
		{{ $title }}
	</a>
</li>