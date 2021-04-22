@extends('phobrv::layout.app')
@section('header')
<a href="{{route('user.create')}}"  class="btn btn-primary float-left">
	<i class="fa fa-edit"></i> @lang('Create new')
</a>
@endsection
@section('content')
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab">User Active</a></li>
		<li><a href="#tab_2" data-toggle="tab">User DisActive</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Roles</th>
						<th>Email</th>
						<th>Date Create</th>
						<th>Reset</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@isset($data['users'])
					@foreach($data['users'] as $u)
					@if($u->stringRole != '')
					<tr>
						<td align="center">{{$u->id}}</td>
						<td>{{$u->name}}</td>
						<td>{{$u->email}}</td>
						<td>{{$u->stringRole}}</td>
						<td align="center">
							{{$u->receive_report}}
						</td>
						<td>{{date('Y-m-d',strtotime($u->created_at))}}</td>
						<td align="center">
							<a href="#" onclick="resetPass('{{$u->id}}')">
								<i class="fa fa-key" aria-hidden="true"></i>
							</a>
						</td>
						<td align="center">
							<a href="{{route('user.edit',array('user'=>$u->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
							&nbsp;&nbsp;&nbsp;
							<a style="color: red" href="#" onclick="deleteUser('destroy{{$u->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
							<form id="destroy{{$u->id}}" action="{{ route('user.destroy',array('user'=>$u->id)) }}" method="post" style="display: none;">
								@method('delete')
								@csrf
							</form>
						</td>
					</tr>
					@endif
					@endforeach
					@endif
				</tbody>

			</table>
		</div>
		<div class="tab-pane" id="tab_2">
			<table id="example2" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Roles</th>
						<th>Received report</th>
						<th>Date Create</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@isset($data['users'])
					@foreach($data['users'] as $u)
					@if($u->stringRole == '')
					<tr>
						<td align="center">{{$u->id}}</td>
						<td>{{$u->name}}</td>
						<td>{{$u->email}}</td>
						<td>{{$u->stringRole}}</td>
						<td align="center">
							{{$u->receive_report}}
						</td>
						<td>{{date('Y-m-d',strtotime($u->created_at))}}</td>
						<td align="center">
							<a href="{{route('user.edit',array('user'=>$u->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
							&nbsp;&nbsp;&nbsp;
							<a style="color: red" href="#" onclick="deleteUser('destroy{{$u->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
							<form id="destroy{{$u->id}}" action="{{ route('user.destroy',array('user'=>$u->id)) }}" method="post" style="display: none;">
								@method('delete')
								@csrf
							</form>
						</td>
					</tr>
					@endif
					@endforeach
					@endif
				</tbody>

			</table>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function deleteUser(form){
		var anwser =  confirm("Bạn muốn khoá tài khoản này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
	function resetPass(id)
	{
		var anwser =  confirm("Bạn muốn đặt lại pass tài khoản này?");
		if(anwser)
		{
			$.ajax({
					headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					url:"{{route('user.resetPass')}}",
					method:"POST",
					data:{user_id:id},
					success:function(data){
						alert("Mật khẩu mới: "+data+" đã được gửi đến email của tài khoản.");
					}
				});
		}
	}
</script>
@endsection