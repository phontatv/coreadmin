@extends('phobrv::layout.app')

@section('header')
<ul>
<li>
<a href="{{route('productitem.create')}}"  class="btn btn-primary float-left">
    <i class="fa fa-edit"></i> @lang('Create new')
</a>
</li>
<li class="text-center">
{{ Form::open(array('route'=>'productitem.updateUserSelectGroup','method'=>'post')) }}
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
					<button id="btnSubmitFilter" class="btn btn-primary ">@lang('Filter')</button>
				</div>
			</td>
		</tr>
	</tbody>
</table>
{{Form::close()}}
</li>
</ul>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>{{__('Name')}}</th>
					<th>{{__('Group')}}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@if($data['products'])
				@foreach($data['products'] as $r)
				<tr>
					<td align="center">{{$loop->index+1}}</td>
					<td><a target="_blank" href="{{ route('level1',['slug'=>$r->slug]) }}">{{$r->title}} </a> </td>
					<td class="list-category">
						@isset($r->terms)
						@foreach($r->terms as $key => $group)
							@isset($data['arrayGroup'][$group->id])
								<span class="comma"> , </span> {{$group->name}}
							@endif
						@endforeach
						@endisset

					</td>
					<td align="center">
						<a href="{{route('productitem.edit',array('productitem'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
						&nbsp;&nbsp;&nbsp;
						<a style="color: red" href="#" onclick="destroy('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
						<form id="destroy{{$r->id}}" action="{{ route('productitem.destroy',array('productitem'=>$r->id)) }}" method="post" style="display: none;">
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

@endsection

@section('styles')

@endsection

@section('scripts')
<script type="text/javascript">
	function destroy(form){
		var anwser =  confirm("Bạn muốn xóa sản phẩm này?");
		if(anwser){
			event.preventDefault();
			document.getElementById(form).submit();
		}
	}
</script>
@endsection