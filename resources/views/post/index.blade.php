@extends('phobrv::layout.app')

@section('header')
<ul>
	<li>
		<a href="{{route('post.create')}}"  class="btn btn-primary float-left">
			<i class="fa fa-edit"></i> @lang('Create new')
		</a>
	</li>
	<li>
		{{ Form::open(array('route'=>'post.updateUserSelectCategory','method'=>'post')) }}
		<table class="form" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td style="text-align:center; padding-right: 10px;">
						<div class="form-group">
							{{ Form::select('select',$data['arrayCategory'],(isset($data['select']) ? $data['select'] : '0'),array('id'=>'choose','class'=>'form-control')) }}
						</div>
					</td>
					<td>
						<div class="form-group">
							<button id="btnSubmitFilter" class="btn btn-primary ">@lang('Filter')</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		{{Form::close()}}
	</li>
</ul>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table id="tableTrust" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>{{__('Date')}}</th>
					<th>{{__('Title')}}</th>
					<th>{{__('Author')}}</th>
					<th>{{__('Status')}}</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@endsection

@section('styles')
<style type="text/css">

</style>
@endsection

@section('scripts')
<script type="text/javascript">
	table =  $('#tableTrust').DataTable({
		lengthMenu: [[15,35,50, -1], [15,35,50, "All"]],
		processing: true,
		serverSide: true,
		ajax: "{{ route('post.getData') }}",
		columns:
		[
		{ data: 'id', name: 'id' ,className:'text-center'},
		{ data: 'create_date', name: 'create_date',className:'text-center' },
		{ data: 'title', name: 'title' },
		{ data: 'author_name', name: 'author_name' },
		{ data: 'status', name: 'status', orderable: false, searchable: false,className:'text-center'},
		{ data: 'edit', name: 'edit',orderable: false, searchable: false,className:'text-center'},
		{ data: 'delete', name: 'delete',orderable: false, searchable: false,className:'text-center'},
		]
	})

	function destroy(form){
		var anwser =  confirm("Bạn muốn xóa bài viết này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
	function changeStatus(id){
		var obj = $('#status'+id)
		var result = confirm("Bạn có muốn thay đổi trạng thái của bài viết này?");
		if (result == true) {
			$.ajax({
				headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: '{{URL::route("post.changeStatus")}}',
				type: 'POST',
				data: {id: id},
				success: function(output){
					console.log(output);
					if (output == 1){
						$(obj).html('');
						$(obj).append('<i class="fa fa-check" style="color:green;"></i>');
					} else{
						$(obj).html('');
						$(obj).append('<i class="fa fa-times-circle" style="color:red"></i>');
					}
				}
			});
		}
	}
</script>
@endsection



