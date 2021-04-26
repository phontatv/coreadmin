@extends('phobrv::layout.app')

@section('header')
<a href="{{route('question.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-edit"></i> @lang('Back')
</a>
<a href="#" onclick="save()"  class="btn btn-primary float-left">
	<i class="fa fa-edit"></i> @lang('Save & Close')
</a>
<a href="#" onclick="update()"  class="btn btn-warning float-left">
	<i class="fa fa-edit"></i> @lang('Update')
</a>
@endsection

@section('content')

<div class="box box-primary">
	<div class="box-body">
		<div class="row">
			<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('question.update',array('question'=>$data['post']->id)) : route('question.store')}}"  enctype="multipart/form-data">
				<input type="hidden" name="term_id" value="{{ $data['select'] }}">
				@csrf
				@isset($data['post']) @method('put') @endisset
				<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
				<div class="col-md-8">
					@isset($data['post'])
					@include('phobrv::input.inputText',['label'=>'Url','key'=>'slug'])
					@endif
					@include('phobrv::input.inputText',['label'=>'Title','key'=>'title','required'=>true])
					@include('phobrv::input.inputText',['label'=>'Question','key'=>'excerpt','required'=>true])
					@include('phobrv::input.inputTextarea',['label'=>'Câu trả lời','key'=>'content'])

					<label class="font16" style="margin-top: 10px;">{{__('Seo Meta')}}</label>
					@include('phobrv::input.inputText',['label'=>'Meta Title','key'=>'meta_title','type'=>'meta'])
					@include('phobrv::input.inputText',['label'=>'Meta Description','key'=>'meta_description','type'=>'meta'])
					@include('phobrv::input.inputText',['label'=>'Meta Keywords','key'=>'meta_keywords','type'=>'meta'])
				</div>
				<div class="col-md-4">
					@include('phobrv::input.inputImage',['key'=>'thumb'])
					<div class="form-group">
						<div class="col-sm-12">
							<label  class="font16">Group</label>
						</div>
						@isset($data['categorys'])
						<ul>
							@foreach($data['categorys'] as $cate)
							<li>
								<input type="checkbox" name="category[]" value="{{$cate->id}}" @if(in_array($cate->id,$data['arrayCategoryID'])) checked @endif> {{$cate->name}}
							</li>
							@if(isset($cate->child))
							@foreach($cate->child as $c)
							<li style="padding-left: 30px;">
								<input type="checkbox" name="category[]" value="{{$c->id}}" @if(in_array($c->id,$data['arrayCategoryID'])) checked @endif> {{$c->name}}
							</li>
							@endforeach
							@endif
							@endforeach
						</ul>
						@endisset
					</div>
				</div>
				<button id="btnSubmit" style="display: none" type="submit" ></button>
			</form>


		</div>
	</div>
</div>

@endsection

@section('styles')
<style type="text/css">

</style>
@endsection

@section('scripts')
<script type="text/javascript">
	window.onload = function() {
		CKEDITOR.replace('content', options);
	};
</script>
@endsection