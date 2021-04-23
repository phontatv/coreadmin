@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Regions')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box  box-primary">
			<div class="box-header">
				Create/Edit Region
			</div>
			<form class="form-horizontal" id="formSubmit" method="post" action="{{isset($data['term']) ? route('region.update',array('region'=>$data['term']->id)) : route('region.store')}}">
				<div class="box-body">
					<input type="hidden" name="taxonomy" value="region">
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
							<td align="center">{{$loop->index+1}}</td>
							<td>{{$r->name}}</td>
							<td>{{$r->description}}</td>
							<td align="center">
								<a href="{{route('region.edit',array('region'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
								&nbsp;&nbsp;&nbsp;
								<a style="color: red" href="#" onclick="destroy('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
								<form id="destroy{{$r->id}}" action="{{ route('region.destroy',array('region'=>$r->id)) }}" method="post" style="display: none;">
									@method('delete')
									@csrf
								</form>
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
	function destroy(form){
		var anwser =  confirm("Bạn muốn xóa region này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
</script>
@endsection