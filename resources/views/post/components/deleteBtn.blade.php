<a style="color: red" href="#" onclick="destroy('destroy{{$post->id}}')"><i class="fa fa-trash" title="Delete"></i></a>
<form id="destroy{{$post->id}}" action="{{ route('post.destroy',array('post'=>$post->id)) }}" method="post" style="display: none;">
	@method('delete')
	@csrf
</form>