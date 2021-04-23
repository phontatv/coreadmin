@extends('phobrv::layout.app')

@section('header')
<a href="{{route('albumgroup.index')}}"  class="btn btn-default float-left">
	<i class="fa fa-backward"></i> @lang('Back')
</a>
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="box  box-primary">
			<div class="box-body">
				<form class="form-horizontal" id="formSubmit" method="post" action="{{route('album.store',['id'=>$data['post']->id])}}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" id="typeSubmit" name="typeSubmit" value="">
					<div class="form-group">
						<div class="col-sm-10">
							@include('admin.input.inputImage',['key'=>'images','basic'=>true])
						</div>
						<div class="col-sm-2">
							<button class=" pull-left btn-primary btn"  type="submit" >Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<form  id="formImages" action="{{route('album.updataImages',['id'=>$data['post']->id])}}" method="post">
			@csrf
			<div class="box  box-primary">
				<div class="box-header">
					{{__('Album Images')}}
				</div>
				<div class="box-body">
					<table  class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Info</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@isset($data['images'])
							@foreach($data['images'] as $img)
							<tr>
								<td>{{$loop->index+1}}</td>
								<td align="center" style="vertical-align: middle;">
									<img src="{{$img->thumb}}" width="100">
								</td>
								<td>
									<input type="hidden" name="id[]" value="{{$img->id}}">
									<label>Name</label>
									<div class="form-group">
										{{ Form::text('title[]',isset($img->title) ? $img->title : '',array('class'=>'form-control','placeholder'=>'Name')) }}
									</div>
									<label>Link</label>
									<div class="form-group">
										{{ Form::text('excerpt[]',isset($img->excerpt) ? $img->excerpt : '',array('class'=>'form-control','placeholder'=>'Link')) }}
									</div>
								</td>
								<td align="center" style="vertical-align: middle;">
									<a href="{{route('album.changeOrder',array('id'=>$data['post']->id,'image'=>$img->id,'type'=>'plus'))}}">
										<i class="fa fa-fw fa-chevron-circle-up"></i>
									</a>

									<a href="{{route('album.changeOrder',array('id'=>$data['post']->id,'image'=>$img->id,'type'=>'minus'))}}">
										<i class="fa fa-fw fa-chevron-circle-down"></i>
									</a>
								</td>
								<td align="center" style="vertical-align: middle;">
									<a href="#" onclick="destroy('{{route('album.delete',['id'=>$data['post']->id, 'album'=>$img->id])}}')"  style="color: red;">
										<i class="fa fa-times" title="Delete"></i>
									</a>

								</td>
								<td>
									<button class="pull-right btn-primary btn" type="submit">@lang('Update')</button>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">
	function updateImages()
	{
		$('#formImages').submit();
	}
</script>
@endsection