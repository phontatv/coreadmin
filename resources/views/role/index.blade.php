@extends('phobrv::layout.app')

@section('header')
<a href="{{route('role.create')}}"  class="btn btn-primary float-left">
	<i class="fa fa-edit"></i> @lang('Create new')
</a>
<a href="" onclick="reloadPermission()" class="btn btn-warning float-left">
	<i class="fa fa-edit"></i> Reload Permission
</a>

@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Permissions</th>
					<th class="text-center">Date Create</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@isset($data['roles'])
				@foreach($data['roles'] as $r)
				<tr>
					<td align="center">{{$r->id}}</td>
					<td>{{$r->name}}</td>
					<td width="500">{{$r->stringPermission}}</td>
					<td align="center">{{date('Y-m-d',strtotime($r->created_at))}}</td>
					<td align="center">
						@if($loop->index >0)
						<a href="{{route('role.edit',array('role'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
						&nbsp;&nbsp;&nbsp;
						<a style="color: red" href="#" onclick="deleteRole('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
						<form id="destroy{{$r->id}}" action="{{ route('role.destroy',array('role'=>$r->id)) }}" method="post" style="display: none;">
							@method('delete')
							@csrf
						</form>
						@endif
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>

		</table>
	</div>
	<!-- /.box-body -->
</div>
@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">
	function deleteRole(form){
		var anwser =  confirm("Bạn muốn xóa role này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
	function reloadPermission(){
		$.ajax({
			url: '{{route('permission.reimport')}}',
			type: 'GET',

		}).done(function(output) {
			alert('Reload success!');
		}).fail(function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
		});
	}
</script>
@endsection