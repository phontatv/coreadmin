<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm"  enctype="multipart/form-data">
		<input type="hidden" name="type" value="web">
		@csrf
		<div class="box-body">
			<label class="font16"> Nội dung file robots.txt </label>
			{{ Form::textarea('robots_txt',old('robots_txt',isset($data['configs']['robots_txt']) ? $data['configs']['robots_txt'] : ''),array('class'=>'form-control','placeholder'=>'Nhập robots_txt','rows'=>'10')) }}
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>