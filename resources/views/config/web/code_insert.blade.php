<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm" enctype="multipart/form-data">
		<input type="hidden" name="type" value="web">

		@csrf
		<div class="box-body">
			<div class="rows">
				<div class="col-xs-12 col-lg-6">
					<label class="font16">Code head - được chèn ngay phía trên thẻ "/head" </label>
					{{ Form::textarea('code_head',old('code_head',isset($data['configs']['code_head']) ? $data['configs']['code_head'] : ''),array('class'=>'form-control','placeholder'=>'Nhập code_head','rows'=>'15')) }}
				</div>
				<div class="col-xs-12 col-lg-6">
					<label class="font16">Code body - được chèn ngay phía trên thẻ "/body" </label>
					{{ Form::textarea('code_body',old('code_body',isset($data['configs']['code_body']) ? $data['configs']['code_body'] : ''),array('class'=>'form-control','placeholder'=>'Nhập code_body','rows'=>'15')) }}
				</div>
			</div>
		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>