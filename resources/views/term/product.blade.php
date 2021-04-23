@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Products')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box  box-primary">
			<div class="box-header">
				{{__('Create/Edit Product Group')}}
			</div>
			<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['term']) ? route('product.update',array('product'=>$data['term']->id)) : route('product.store')}}">
				<div class="box-body">
					<input type="hidden" name="taxonomy" value="product">
					@isset($data['term']) @method('put') @endisset
					@csrf
					<div class="form-group">
						<div class="col-sm-12">
							{{Form::text('name', old('name',isset($data['term']->name) ? $data['term']->name :'' ),['class'=>'form-control','placeholder'=>'Name','required'=>'required'])}}
							@if ($errors->has('slug') )
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
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@isset($data['terms'])
						@foreach($data['terms'] as $r)
						<tr>
							<td>{{$loop->index+1}}</td>
							<td>
								<a href="#">
									{{$r->name}}
								</a>
							</td>
							<td>{{$r->description}}</td>
							<td align="center">
								<a href="{{route('product.edit',array('product'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>

								&nbsp;&nbsp;&nbsp;
								<a  href="{{route('productitem.index',array('id'=>$r->id))}}" ><i class="fa fa-cog" title="Config"></i></a>

								@if(count($r->posts)==0 && !@isset($r->child))
								&nbsp;&nbsp;&nbsp;
								<a style="color: red" href="#" onclick="destroyCategory('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
								<form id="destroy{{$r->id}}" action="{{ route('product.destroy',array('product'=>$r->id)) }}" method="post" style="display: none;">
									@method('delete')
									@csrf
								</form>
								@endif
							</td>
						</tr>
						@isset($r->child)
						@foreach($r->child as $rc)
						<tr>
							<td>{{$loop->index+1}}</td>
							<td style="padding-left: 30px;">-- {{$rc->name}}</td>
							<td>{{$rc->description}}</td>
							<td align="center">
								<a href="{{route('product.edit',array('product'=>$rc->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
								&nbsp;&nbsp;&nbsp;
								<a  href="{{route('productitem.index',array('id'=>$rc->id))}}" ><i class="fa fa-cog" title="Config"></i></a>
								@if(count($rc->posts)==0)
								&nbsp;&nbsp;&nbsp;
								<a style="color: red" href="#" onclick="destroyCategory('destroy{{$rc->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
								<form id="destroy{{$rc->id}}" action="{{ route('product.destroy',array('product'=>$rc->id)) }}" method="post" style="display: none;">
									@method('delete')
									@csrf
								</form>
								@endif
							</td>
						</tr>
						@endforeach
						@endisset
						@endforeach
						@endisset
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
		var anwser =  confirm("Bạn muốn xóa product này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
</script>
@endsection