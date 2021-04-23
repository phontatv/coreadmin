<script type="text/javascript">
	$('.ConfigForm').submit(function(e){
		e.preventDefault();
		var files = $(this).find('.inputfile')
		for(var i=0;i<files.length ;i++)
		{
			updateImage(files[i].id)
		}
		var data = {};
		var getData = $(this).serializeArray();
		for(var i=0;i<getData.length;i++){
			if(getData[i]['name']!='_token')
				data[getData[i]['name']] = getData[i]['value'];
		}

		$.ajax({
			headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: '{{URL::route("configAPI.update")}}',
			type: 'POST',
			data: {data: data},
			success: function(output){
				alertOutput(output['msg'],output['message'])
			}
		});
	})

	function updateImage(id)
	{
		var res = $('#'+id).val();
		var inputClass = id.replace('input','')
		$('.'+inputClass).attr("src",res)
	}
</script>