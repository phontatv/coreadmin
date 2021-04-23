<a id="status{{ $post->id }}" href="javascript:changeStatus('{{ $post->id }}')">
	@if($post->status  == 1)
	<i class="fa fa-check" style="color:green;"></i>
	@else
	<i class="fa fa-times-circle" style="color:red"></i>
	@endif
</a>