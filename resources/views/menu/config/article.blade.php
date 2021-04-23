<div class="box box-primary">
	<div class="box-header"  id="header-b1">
		<h3 class="box-title">Cấu hình page</h3>
	</div>
	<form  class="form-horizontal"  method="post" action="{{route('menu.updateContent',['menu'=>$data['post']->id])}}"  enctype="multipart/form-data">
		<input type="hidden" name="typeSubmit" id="typeSubmit" value="update">
		@csrf
		<div class="box-body">
			@include('admin.input.inputFile',['label'=>'Thumb','key'=>'thumb','width'=>'200px'])
			@include('admin.input.inputTextarea',['label'=>'Content','key'=>'content'])
		</div>
		<div class="box-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>
<script type="text/javascript">
	window.onload = function() {
		CKEDITOR.replace('content', options);
	};
</script>