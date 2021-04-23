<div class="box box-primary">
	<div class="box-header"  id="header-b1">
		<h3 class="box-title">Cấu hình page</h3>
	</div>
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
		@csrf
		<div class="box-body">
			@include('admin.input.inputText',['label'=>'Link','key'=>'link','type'=>'meta'])
		</div>
		<div class="box-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary')) }}
		</div>
	</form>
</div>
