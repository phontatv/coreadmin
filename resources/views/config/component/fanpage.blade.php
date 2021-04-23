<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm" enctype="multipart/form-data">
		<input type="hidden" name="type" value="component">
		@csrf
		<div class="box-body">
			@include('admin.input.inputText',['label'=>'Title','key'=>'box1_title','type'=>'configs'])
			@include('admin.input.inputTextarea',['label'=>'Code fanpage','key'=>'code_fanpage','type'=>'configs'])
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>