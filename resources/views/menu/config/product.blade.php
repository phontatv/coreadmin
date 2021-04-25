<div class="box box-primary">
	<div class="box-header" >
		<h3 class="box-title">Cấu hình page</h3>
	</div>
	<form class="form-horizontal MenuForm"  enctype="multipart/form-data">
		<input type="hidden" name="menu_id" value="{{ $data['post']->id }}">
		@csrf
		<div class="box-body">
			@include('phobrv::input.inputSelect',['label'=>'Product Group','key'=>'product_term_paginate','type'=>'meta','array'=>$arrayProductGroup])
			@include('phobrv::input.inputFile',['label'=>'Banner','key'=>'banner_image','width'=>'100%'])
		</div>
		<div class="box-footer">
			{{ Form::submit('Lưu cấu hình',array('class'=>'btn btn-primary pull-right')) }}
		</div>
	</form>
</div>