<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm"  enctype="multipart/form-data">
		<input type="hidden" name="type" value="web">
		@csrf
		<div class="box-body">
			<label class="font16"> Nội dung file customize.css </label>
			{{ Form::textarea('customize_css',old('customize_css',isset($data['configs']['customize_css']) ? $data['configs']['customize_css'] : ''),array('class'=>'form-control','placeholder'=>'Nhập customize_css','rows'=>'20')) }}
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>
