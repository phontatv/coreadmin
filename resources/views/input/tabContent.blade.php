@php
	$active = isset($active) ? $active : "";
@endphp
<div role="tabpanel" class="tab-pane {{ $active }}" id="{{ $id }}">
	@include($view)
</div>