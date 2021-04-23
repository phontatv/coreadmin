<div class='box box-primary'>
	<div class="box-body">
		<div class="form-horizontal">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Maintenance</label>
				<div class="col-sm-10">
					<a id="btnTurnOn" href="#" onclick="maintenance(0)" class="btn btn-primary">
						Turn on website
					</a>
					<a id="btnTurnOff" href="#" onclick="maintenance(1)" class="btn btn-danger">
						Turn off website
					</a>
				</div>
			</div>
		</div>
		<input type="hidden" id="isMainenance" name="isMainenance" value="{{ $data['configs']['maintenance'] }}">
	</div>
	<form  class="form-horizontal ConfigForm"  enctype="multipart/form-data">
		<input type="hidden" name="type" value="web">
		@csrf
		<div class="box-body">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Tempalte Web</label>
				<div class="col-sm-10">
					{{ Form::text('theme',$arrayTheme[config('option.theme')],array('class'=>'form-control','placeholder'=>'Theme','readonly'=>'readonly')) }}
				</div>
			</div>
			@include('admin.input.inputSelect',['label'=>'Main Menu','key'=>'main_menu','array'=>$arrayMenu,'type'=>'configs'])
			@include('admin.input.inputText',['label'=>'Name Web','key'=>'site_name','type'=>'configs'])
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right">{{__('Submit')}}</button>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">

	$(function(){
		var isMainenance = $('#isMainenance').val();
		console.log(isMainenance);
		changeBtnMaintenance(isMainenance);
	})

	function changeBtnMaintenance(isMainenance)
	{
		var i = parseInt(isMainenance)
		switch(i)
		{
			case 1:
			$('#btnTurnOn').css('display','block');
			$('#btnTurnOff').css('display','none');
			break;
			default:
			$('#btnTurnOn').css('display','none');
			$('#btnTurnOff').css('display','block');
			break;
		}
	}

	function maintenance(off)
	{
		if(off == 1 )
			var answer = confirm("Bạn muốn đóng website?");
		else
			var answer = confirm("Bạn muốn mở lại website?");

		if(answer)
		{
			$.ajax({
				headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: '{{URL::route("config.maintenanceWebsite")}}',
				type: 'POST',
				data: {off: off},
				success: function(output){
					changeBtnMaintenance(output['off']);
					alertOutput(output['msg'],output['message'])

				}
			});
		}


	}
</script>
