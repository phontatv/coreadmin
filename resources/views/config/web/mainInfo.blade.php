<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm"  enctype="multipart/form-data">
		<input type="hidden" name="type" value="web">
		@csrf
		<div class="box-body">
			<label class="font16">Contact</label>
			@include('admin.input.inputText',['label'=>'Hotline number','key'=>'hotline_number','type'=>'configs'])
			@include('admin.input.inputText',['label'=>'Email','key'=>'company_email','type'=>'configs'])
			<hr class="border-light">
			<label class="font16">Info</label>
			@include('admin.input.inputText',['label'=>'Tên công ty','key'=>'company_name','type'=>'configs'])
			@include('admin.input.inputText',['label'=>'Address','key'=>'company_add','type'=>'configs'])

			<hr class="border-light">
			<label  class="font16">Copyright</label>
			@include('admin.input.inputText',['label'=>'Copyright','key'=>'copyright','type'=>'configs'])
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right">{{__('Submit')}}</button>
			</div>
		</form>
	</div>
</div>
