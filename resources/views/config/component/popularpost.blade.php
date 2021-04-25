<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm" enctype="multipart/form-data">
		<input type="hidden" name="type" value="component">
		@csrf
		<div class="box-body">
			@include('phobrv::input.inputText',['label'=>'Title','key'=>'box2_title','type'=>'configs'])
			@include('phobrv::input.inputText',['label'=>'Số lượng bài viết','key'=>'box2_number','inputType'=>'number','type'=>'configs'])
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>