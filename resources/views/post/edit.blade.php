@extends('phobrv::layout.app')

@section('header')
<a href="{{route('post.index')}}"  class="btn btn-default float-left">
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
	<div class="box-body">
		<div class="row">

			<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('post.update',array('post'=>$data['post']->id)) : route('post.store')}}"  enctype="multipart/form-data">
				@csrf
				@isset($data['post']) @method('put') @endisset
				<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
				<div class="col-md-8">
					@isset($data['post'])
					@include('admin.input.inputText',['label'=>'Url','key'=>'slug','check_auto_gen'=>'true'])
					@endif
					@include('admin.input.inputText',['label'=>'Title','key'=>'title','required'=>true])
					@include('admin.input.inputText',['label'=>'Description','key'=>'excerpt'])
					@isset($data['post'])
					@include('admin.input.inputText',['label'=>'Create date','key'=>'created_at','datepicker'=>true])
					@endif
					@include('admin.input.inputTextarea',['key'=>'content','label'=>'content','style'=>'short'])
					<label class="font16" style="margin-top: 10px;">{{__('Seo Meta')}}</label>
					@include('admin.input.inputText',['label'=>'Meta Title','key'=>'meta_title','type'=>'meta'])
					@include('admin.input.inputText',['label'=>'Meta Description','key'=>'meta_description','type'=>'meta'])
					@include('admin.input.inputText',['label'=>'Meta Keywords','key'=>'meta_keywords','type'=>'meta'])
				</div>
				<div class="col-md-4">
					@include('admin.input.inputImage',['key'=>'thumb'])
					<hr>
					<div class="form-group">
						<div class="col-sm-12">
							<label  class="font16">Catergorys</label>
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
					<hr>
					<div id="listTagHidden">
						@if(isset($data['tags']))
						@foreach($data['tags'] as $key => $tag )
						<span class="tag{{$key}}">
							<input  type="hidden" name="tag[]" value="{{$tag}}">
						</span>
						@endforeach
						@endif
					</div>
				</div>
				<button id="btnSubmit" style="display: none" type="submit" ></button>
				@php if(isset($data['post'])) $action = 'update'; else $action = 'create';   @endphp
				<input type="hidden" name="content_draft" id="content_draft">
				<input type="hidden" name="id_post" id="id_post" value="@isset($data['post']){{$data['post']->id}}@endif">

			</form>
			<div  class="col-md-4">
				<label class="font16">Tags</label>
				<div class="form-group" id="listTagShow">
					@isset($data['tags'])
					@foreach($data['tags']  as $key => $tag )
					<span class="show tag{{$key}}">
						<span class="btn bg-purple btn-flat ">{{$tag}}</span>
						<i onclick="removeClass('tag{{$key}}')" class="fa fa-fw fa-times-circle"></i>
					</span>
					@endforeach
					@endisset
				</div>
				<div class="form-group">
					{{Form::text('taginput',old('taginput',''),array('class'=>'form-control','placeholder'=>'Nhập tag cần thêm','id'=>'taginput')) }}
				</div>
				<div id="listSearch"><br></div>
				<div class="form-group">
					<button class="btn-primary btn pull-right" onclick="addTag()">Add Tag</button>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection

@section('styles')
<style type="text/css">
	#listTagShow .btn-flat{
		margin-top: 3px;
		margin-bottom: 5px;
	}
	#listTagShow .show{
		position: relative;
		padding-right: 15px;
		float: left;
	}
	#listTagShow .show i{
		position: absolute;
		z-index: 1;
		top: -5px;
		right: 3px;
		color: red;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
	$(function(){
		setInterval(function(){ updatePostAuto(); }, 30000);
	})
	function updatePostAuto(){
		var content = CKEDITOR.instances['content'].getData();
		$("#content_draft").val(content);
		var action_type = $("#action_type").val();
		var data = $('#formSubmit').serializeArray();
		var id =  $("#id_post").val();
		$.ajax({
			headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url:"{{route('post.autoUpdatePostContent')}}",
			method:"POST",
			data:{data:data},
			success:function(output){
				console.log(output);
			}
		});
	}
	function addTag(){
		var tag = document.getElementById("tags");
		var tagContent = tag.value;
		console.log(tagContent);
	}

	window.onload = function() {
		CKEDITOR.replace('content', options);

	};

	function addTag(){
		var tagContent = $('#taginput').val();
		console.log(tagContent);
		if(tagContent != ""){
			var now = new Date();
			var numberTag = now.getTime();
			var stringHidden = '<span class="tag'+numberTag+'"> <input type="hidden" name="tag[]" value="'+tagContent+'"></span>';
			var stringShow =  '<span class="show tag'+numberTag+'"> <span class="btn bg-purple btn-flat ">'+tagContent+'</span>'+
			'<i onclick="removeClass('+ "'tag"+numberTag+"'" +')" class="fa fa-fw fa-times-circle"></i> </span>';
			document.getElementById('listTagHidden').innerHTML +=stringHidden;
			document.getElementById('listTagShow').innerHTML +=stringShow;
			$('#taginput').val("");
		}
	}

	function removeClass(name){
		console.log(name);
		$('.'+name).remove();

	}

	$(function(){
		$('#taginput').keyup(function(){
			var query = $(this).val();
			if(query != ''){
				$.ajax({
					headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					url:"{{route('post.tagSearchAjax')}}",
					method:"POST",
					data:{query:query},
					success:function(data){
						console.log(data);
						$('#listSearch').fadeIn();
						$('#listSearch').html(data);
					}
				});
			}
		});
	});

	$(document).on('click', '#listSearch li', function(){
		$('#taginput').val($(this).text());
		$('#listSearch').fadeOut();
	});
</script>
@endsection