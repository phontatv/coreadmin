@extends('phobrv::.layout.app')

@section('header')
<a href="{{route('user.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>
<a href="#" onclick="save()"  class="btn btn-primary float-left">
	<i class="fa fa-floppy-o"></i> @lang('Save & Close')
</a>
<a href="#" onclick="update()"  class="btn btn-warning float-left">
	<i class="fa fa-wrench"></i> @lang('Update')
</a>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-header">
		<div class="row">
			<div class="col-md-6">
				<h3 class="box-title">User Info</h3>
			</div>
			<div class="col-md-3">
				<h3 class="box-title">User Role</h3>
			</div>
			<div class="col-md-3">
				<h3 class="box-title">Avatar</h3>
			</div>
		</div>
	</div>
	<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('user.update',array('user'=>$data['post']->id)) : route('user.store')}}">
		@csrf
		@isset($data['post']) @method('put') @endisset
		<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="box-body">
						@include('phobrv::input.inputText',['label'=>'Name','key'=>'name','required'=>true])
						@include('phobrv::input.inputText',['label'=>'Email','key'=>'email','required'=>true])
						@if(!isset($data['post']))
						@include('phobrv::input.inputText',['label'=>'Password','key'=>'password','required'=>true])
						@endif
						@include('phobrv::input.inputSelect',['label'=>'Email Report','key'=>'receive_report','array'=>['no'=>'no','yes'=>'yes'],'type'=>'meta'])
						{{-- @include('phobrv::input.inputText',['label'=>'MessengerID','key'=>'mess_id','type'=>'meta']) --}}
						{{-- @include('phobrv::input.inputSelect',['label'=>'Mess Report','key'=>'mess_report','array'=>['no'=>'no','yes'=>'yes'],'type'=>'meta']) --}}
					</div>

				</div>
				<div class="col-md-3">
					<ul id="permissions">
						@if(isset($data['roles']))
						@foreach($data['roles'] as $role )
						<li>
							<input type="checkbox" name="roles[]" value="{{$role->name}}" @if(in_array($role->name, $data['arrayRole'])) checked @endif>
							{{$role->name}}
						</li>
						@endforeach
						@endif
					</ul>
				</div>
				<div class="col-md-3">
					@include('phobrv::input.inputImage',['key'=>'avatar'])
				</div>
			</div>
			<button id="btnSubmit" style="display: none" type="submit" ></button>
		</form>
	</div>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection