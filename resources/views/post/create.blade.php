@extends('phobrv::layout.app')

@section('header')
<a href="{{route('post.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<div class="col-md-8">
				<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('post.update',array('post'=>$data['post']->id)) : route('post.store')}}"  enctype="multipart/form-data">
					@csrf
					<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
					@include('admin.input.inputText',['label'=>'Title','key'=>'title','required'=>true])
					<button id="btnSubmit" style="display: none" type="submit" ></button>
				</form>
			</div>
			<div class="col-md-4">
				<a href="#" onclick="update()"  class="btn btn-warning float-left">
					<i class="fa fa-wrench"></i> @lang('Create')
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')

@endsection

