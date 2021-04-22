<ol class="breadcrumb">
	@if( isset($data['breadcrumbs']) &&  count( $data['breadcrumbs'] )  > 0 )
		<?php $i = 0; ?>
		@foreach( $data['breadcrumbs'] as $breadcrumb )
			<li class="{{ ($breadcrumb['is_active']) ? 'active' : '' }}">
				<a href="{{ $breadcrumb['href'] }}">
					{!! $breadcrumb['text'] !!} 
				</a>
			</li>
		<?php $i++; ?>
		@endforeach
	@endif
</ol>