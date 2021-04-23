@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Cagegories')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box  box-primary">
			<div class="box-header">
				Create/Edit Category
			</div>
			<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['term']) ? route('category.update',array('category'=>$data['term']->id)) : route('category.store')}}">
				<div class="box-body">
					<input type="hidden" name="taxonomy" value="category">
					@isset($data['term']) @method('put') @endisset
					@csrf
					<div class="form-group">
						<div class="col-sm-12">
							{{Form::text('name', old('name',isset($data['term']->name) ? $data['term']->name :'' ),['class'=>'form-control','placeholder'=>'Name','required'=>'required'])}}
							@if ($errors->has('slug') || $errors->has('name') )
							<span class="invalid-feed" role="alert">
								<strong>{{ $errors->first('slug') }}</strong>
							</span>
							@endif
						</div>
					</div>
					@if(!isset($data['child']) ||  count($data['child']) == 0)
					<div class="form-group">
						<div class="col-sm-12">
							{{Form::select('parent', $data['arrayTerm'],(isset($data['term']->parent) ? $data['term']->parent : '0'),array('class'=>'form-control'))}}
						</div>
					</div>
					@endif
					<div class="form-group">
						<div class="col-sm-12">
							{{Form::textarea('description', old('description',isset($data['term']->description) ? $data['term']->description :'' ),['class'=>'form-control','placeholder'=>'Description','rows'=>'5'])}}
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button class="pull-right btn btn-primary" type="submit">{{$data['submit_lable'] ?? ''}}</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-body">
				<table  class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@isset($data['terms'])
						@foreach($data['terms'] as $r)
						<tr>
							<td>{{$r->name}}</td>
							<td>{{$r->description}}</td>
							<td align="center">
								<a href="{{route('category.edit',array('category'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
								&nbsp;&nbsp;&nbsp;
								<a  href="{{route('post.index')}}" ><i class="fa fa-cog" title="Config"></i></a>
								@if($r->child->count() == 0 && $r->posts->count() == 0)
								&nbsp;&nbsp;&nbsp;

								<a style="color: red" href="#" onclick="destroyCategory('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
								<form id="destroy{{$r->id}}" action="{{ route('category.destroy',array('category'=>$r->id)) }}" method="post" style="display: none;">
									@method('delete')
									@csrf
								</form>
								@endif
							</td>
						</tr>
						@isset($r->child)
						@foreach($r->child as $rc)
						<tr>
							<td style="padding-left: 30px;">-- {{$rc->name}}</td>
							<td>{{$rc->description}}</td>
							<td align="center">
								<a href="{{route('category.edit',array('category'=>$rc->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
								&nbsp;&nbsp;&nbsp;
								<a  href="{{route('post.index')}}" ><i class="fa fa-cog" title="Config"></i></a>
								&nbsp;&nbsp;&nbsp;
								@if($rc->posts->count() == 0)
								<a style="color: red" href="#" onclick="destroyCategory('destroy{{$rc->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
								<form id="destroy{{$rc->id}}" action="{{ route('category.destroy',array('category'=>$rc->id)) }}" method="post" style="display: none;">
									@method('delete')
									@csrf
								</form>
								@endif
							</td>
						</tr>
						@endforeach
						@endisset
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
	function destroyCategory(form){
		var anwser =  confirm("Bạn muốn xóa category này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
</script>
@endsection