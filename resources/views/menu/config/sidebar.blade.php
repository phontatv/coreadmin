<div class="box box-primary">
	<div class="box-header"  id="header-b12">
		<h3 class="box-title">Cấu hình box sidebar</h3>
	</div>
	<div class="box-body" id="b12" style="display: block">
		<form method="post" action="{{route('menu.updateMultiMeta',['id'=>$data['post']->id])}}">
			@csrf
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Chọn box sidebar</div>
							{{ Form::select('box_sidebar',$arrayBoxSidebar,'0',array('class' => 'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-md-3">
					{{ Form::submit('Thêm box',array('class'=>'btn btn-primary')) }}
				</div>
			</div>
		</form>
		<table  class="table table-bordered table-hover dataTable">
			<thead >
				<tr>
					<th><div align="center">Box sidebar</div></th>
					<th><div align="center">Action</div></th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['meta']['box_sidebars'] as $key=>$value)
				<tr class="meta_{{ $key }}">
					<td> {{$arrayBoxSidebar[$value]}} </td>
					<td align="center">
						<a href="#" onclick="removeMeta('{{ $key }}')" style="color:red"> <i class="fa fa-times" title="Xóa"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	function removeMeta(meta_id){
		var anwser =  confirm("Bạn muốn box sidebar này?");
		if(anwser){
			$.ajax({
				headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: '{{URL::route("menu.removeMeta")}}',
				type: 'POST',
				data: { meta_id:meta_id},
				success: function(output){
					$('.meta_'+output).remove();
				}
			});
		}
	}
</script>