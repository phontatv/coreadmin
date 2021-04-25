<div class='box box-primary'>
	<form  class="form-horizontal ConfigForm" enctype="multipart/form-data">
		<input type="hidden" name="type" value="component">
		@csrf
		<div class="box-body">
			@include('phobrv::input.inputFile',['label'=>'Icon Phone','key'=>'sbphone_img','width'=>'100px','type'=>'configs'])
			@include('phobrv::input.inputFile',['label'=>'Icon Mail','key'=>'sbmail_img','width'=>'100px','type'=>'configs'])
			@include('phobrv::input.inputFile',['label'=>'Icon Messenger','key'=>'sbmess_img','width'=>'100px','type'=>'configs'])
			@include('phobrv::input.inputFile',['label'=>'Icon Zalo','key'=>'sbzalo_img','width'=>'100px','type'=>'configs'])

		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right">{{__('update')}}</button>
		</div>
	</form>
</div>