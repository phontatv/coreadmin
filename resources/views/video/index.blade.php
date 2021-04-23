@extends('phobrv::layout.app')

@section('header')
<ul>
	<li>
		@if(!isset($data['post']))
		<a href="{{route('videogroup.index')}}"  class="btn btn-default float-left">
			<i class="fa fa-backward"></i> @lang('Back')
		</a>
		@endif
	</li>
	<li>
		<a href="#" onclick="save()" class="btn btn-primary float-left">
			<i class="fa fa-floppy-o"></i> Save&Close
		</a>
	</li>
	<li>
		<form method="post" action="{{route('video.updateVideoGroupSelect')}}">
			@csrf
			<table class="form" width="100%" border="0" cellspacing="1" cellpadding="1">
				<tbody>
					<tr>
						<td style="text-align:center; padding-right: 10px;">
							<div class="form-group">
								{{ Form::select('select',$data['arrayGroup'],(isset($data['select']) ? $data['select'] : '0'),array('id'=>'choose','class'=>'form-control')) }}
							</div>
						</td>
						<td>
							<div class="form-group">
								<button id="btnSubmitFilter" class="btn btn-primary ">{{__('Get')}}</button>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</li>
</ul>



@endsection

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box  box-primary">
			<div class="box-header">
				{{__('Add Video')}}
			</div>
			<div class="box-body">
				<form class="form-horizontal" id="formSubmit" method="post"
				action="{{ isset($data['post']) ? route('video.update',['video'=>$data['post']->id])  : route('video.store')}}"
				enctype="multipart/form-data">
				@csrf
				@isset($data['post']) @method('put') @endisset
				<input type="hidden" id="typeSubmit" name="typeSubmit" value="update">
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
				<label>Id Video</label>
				<div class="form-group">
					<div class="col-sm-8">

						{{Form::text('excerpt',old('excerpt',isset($data['post']) ? $data['post']->excerpt : '' ),['class'=>'form-control','placeholder'=>'Id Video Youtube','required'=>'required', isset($data['post']) ? 'readonly' : "freeread" ])}}
						@if ($errors->has('excerpt') || $errors->has('excerpt') )
						<span class="invalid-feed" role="alert">
							<strong>{{ $errors->first('excerpt') }}</strong>
						</span>
						@endif
					</div>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-warning float-left">
							<i class="fa fa-wrench"></i> @lang('Update')
						</button>

					</div>
				</div>
				@isset($data['post'])
				<div class="form-group">
					<div class="col-sm-12">
						<label>Date Create</label>
						{{Form::text('created_at',old('created_at',isset($data['post']->created_at) ? date('Y-m-d',strtotime($data['post']->created_at)) : '' ),['class'=>'datepicker form-control','placeholder'=>'Meta meta_description'])}}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Thumb</label>
						<img src="{{$data['post']->thumb}}" style="width: 300px;height: auto;" alt="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Title</label>
						{{Form::text('title',old('title',isset($data['post']) ? $data['post']->title : '' ),['class'=>'form-control','placeholder'=>'Title','required'=>'required'])}}
						@if ($errors->has('title') || $errors->has('title') )
						<span class="invalid-feed" role="alert">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Content</label>
						{{Form::textarea('content',old('content',isset($data['post']) ? $data['post']->content : '' ),['class'=>'form-control','placeholder'=>'Content','id'=>'content'])}}
						@if ($errors->has('content') || $errors->has('content') )
						<span class="invalid-feed" role="alert">
							<strong>{{ $errors->first('content') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<label>Seo meta</label>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Meta title</label>
						{{Form::text('meta_title',old('meta_title',isset($data['metas']['meta_title']) ? $data['metas']['meta_title'] : '' ),['class'=>'form-control','placeholder'=>'Meta title'])}}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Meta description</label>
						{{Form::text('meta_description',old('meta_description',isset($data['metas']['meta_description']) ? $data['metas']['meta_description'] : '' ),['class'=>'form-control','placeholder'=>'Meta meta_description'])}}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Meta keywords</label>
						{{Form::text('meta_keywords',old('meta_keywords',isset($data['metas']['meta_keywords']) ? $data['metas']['meta_keywords'] : '' ),['class'=>'form-control','placeholder'=>'Meta meta_keywords'])}}
					</div>
				</div>
				@endif

				<button id="btnSubmit" style="display: none" type="submit" >submit</button>
			</form>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="box  box-primary">
		<div class="box-header">
			{{__('List Video')}}
		</div>
		<div class="box-body">
			<table  class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					@isset($data['videos'])
					@foreach($data['videos'] as $video)
					<tr>
						<td  align="center" style="vertical-align: middle;">{{$loop->index+1}}</td>
						<td width="500">
							<input type="hidden" name="id[]" value="{{$video->id}}">
							<div class="form-group">
								{{ $video->title }}
								<br> <i style="color: #909090"> Create: {{ date('Y-m-d',strtotime($video->created_at)) }}</i>
							</div>
						</td>

						<td align="center" style="vertical-align: middle;" width="80px">
							<a href="{{route('video.edit',['video'=>$video->id])}}">
								<i class="fa fa-edit" title="Edit"></i>
							</a>
							&nbsp;&nbsp;&nbsp;
							<a href="#" onclick="destroy('{{route('video.delete',['id'=>$video->id])}}')"  style="color: red;">
								<i class="fa fa-times" title="Delete"></i>
							</a>

						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>

</div>
</div>
@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">
	window.onload = function() {
		CKEDITOR.replace('content', options);
	};
	function save(){
		$('#typeSubmit').val('save');
		$('#btnSubmit').click();
	}
	function update(){
		console.log("@lang('Update')");
		$('#typeSubmit').val('update');
		$('#btnSubmit').click();
	}
	function destroy(url) {
		var anwser =  confirm("Bạn muốn xóa video này?");
		if(anwser){
			window.location=url;
		}
	}
</script>
@endsection