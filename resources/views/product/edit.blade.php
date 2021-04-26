@extends('phobrv::layout.app')

@section('header')
<a href="{{route('productitem.index')}}"  class="btn btn-default float-left">
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


<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['post']) ? route('productitem.update',array('productitem'=>$data['post']->id)) : route('productitem.store')}}"  enctype="multipart/form-data">
	@csrf
	@isset($data['post']) @method('put') @endisset
	<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Main</a></li>
			<li><a href="#tab_2" data-toggle="tab">Detail</a></li>
			<li><a href="#tab_3" data-toggle="tab">Gallery</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				@include('phobrv::product.main')
			</div>
			<div class="tab-pane" id="tab_2">
				@include('phobrv::product.detail')
			</div>
			<div class="tab-pane" id="tab_3">
				@include('phobrv::product.gallery')
			</div>
		</div>
	</div>
	<button id="btnSubmit" style="display: none" type="submit" ></button>
</form>


@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">
	window.onload = function() {
		CKEDITOR.replace('content', options);
	};

	function deleteImage(meta_id){

		var anwser =  confirm("Bạn muốn image này?");
		if(anwser){
			$.ajax({
				headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: '{{ route('productitem.deleteMetaAPI') }}',
				type: 'POST',
				data: {meta_id: meta_id},
				success: function (res) {
					console.log(res);
					if(res)
					{
						$('.thumb'+meta_id).css('display','none');
					}
				}
			});
		}
	}
</script>
@endsection