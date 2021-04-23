@extends('phobrv::layout.app')

@section('header')
<a href="{{route('menu.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>
@endsection

@section('content')

<div class="row">
	<div class="col-sm-3">
		<ul class="nav nav-pills nav-stacked">
			@include('admin.input.navTab',['id'=>'mainInfo','title'=>'Main Info','active'=>'active'])
			@switch($data['post']->subtype)
			@case('home')
			@include('admin.menu.home.nav')
			@break
			@case('category')
			@include('admin.input.navTab',['id'=>'category','title'=>'Cấu hình page'])
			@break
			@case('article')
			@include('admin.input.navTab',['id'=>'article','title'=>'Cấu hình page'])
			@break
			@case('contact')
			@include('admin.input.navTab',['id'=>'contact','title'=>'Cấu hình page'])
			@break
			@case('product')
			@include('admin.input.navTab',['id'=>'product','title'=>'Cấu hình page'])
			@break
			@endswitch

			@switch($data['post']->subtype)
			@case('category')
			@include('admin.input.navTab',['id'=>'sidebar','title'=>'Cấu hình box sidebar'])
			@break
			@endswitch
		</ul>
	</div>
	<div class="col-sm-9">
		<div class="tab-content">
			@include('admin.input.tabContent',['id'=>'mainInfo','view'=>'admin.menu.mainInfo','active'=>'active'])
			@switch($data['post']->subtype)
			@case('home')
			@include('admin.menu.home.tabpanel')
			@break
			@case('category')
			@include('admin.input.tabContent',['id'=>'category','view'=>'admin.menu.config.category'])
			@break
			@case('article')
			@include('admin.input.tabContent',['id'=>'article','view'=>'admin.menu.config.article'])
			@break
			@case('contact')
			@include('admin.input.tabContent',['id'=>'contact','view'=>'admin.menu.config.contact'])
			@break
			@case('product')
			@include('admin.input.tabContent',['id'=>'product','view'=>'admin.menu.config.product'])
			@break
			@endswitch

			@switch($data['post']->subtype)
			@case('category')
			@include('admin.input.tabContent',['id'=>'sidebar','view'=>'admin.menu.config.sidebar'])
			@break
			@endswitch
		</div>
	</div>

</div>

@endsection

@section('styles')
<style type="text/css">
	.select2{
		width: 100%!important;
	}
</style>

@endsection

@section('scripts')
<script type="text/javascript">
	$('.MenuForm').submit(function(e){
		e.preventDefault();

		var data = {};
		var getData = $(this).serializeArray();
		for(var i=0;i<getData.length;i++){
			if(getData[i]['name']!='_token')
				data[getData[i]['name']] = getData[i]['value'];
		}
		var editors = $(this).find('textarea');
		for(var j=0;j<editors.length;j++)
		{
			var name = editors[j].name;
			if(CKEDITOR.instances[name])
				data[name] = CKEDITOR.instances[name].getData();
		}


		var files = $(this).find('input[type="file"]')
		for(var i=0;i<files.length ;i++)
		{
			uploadImage(files[i].id,data['menu_id'])
		}

		$.ajax({
			headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: '{{URL::route("menu.updateMetaAPI")}}',
			type: 'POST',
			data: {data: data},
			success: function(output){
				// console.log(output);
				alertOutput(output['msg'],output['message'])
			}
		});
	})


	function uploadImage(id,menu_id)
	{
		if($("#"+id).length > 0 )
		{
			var file_data = $("#"+id).prop('files')[0];
			if(file_data)
			{
				var type = file_data.type;
				var match = ["image/gif", "image/png", "image/jpg","image/jpeg"];
				var form_data = new FormData();
				form_data.append('file', file_data);
				form_data.append('key',id);
				form_data.append('menu_id',menu_id);
				var url = '{{route("menu.uploadFileAPI")}}';
				$.ajax({
					headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					url: url,
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function (res) {
							// console.log(res)
							$("#"+id).val('');
							$('.'+id).attr("src",res);
						}
					});
			}
		}
	}

</script>
@endsection