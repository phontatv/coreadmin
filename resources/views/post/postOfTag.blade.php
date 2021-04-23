@extends('phobrv::layout.app')

@section('header')
<ul>
	<a href="{{route('tag.index')}}"  class="btn btn-primary float-left">
	    <i class="fa fa-edit"></i> @lang('Back')
	</a>
</ul>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>{{__('Date')}}</th>
					<th>{{__('Title')}}</th>
					<th>{{__('Author')}}</th>
					<th>{{__('Categorys')}}</th>
					<th>{{__('Tags')}}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@isset($data['tag']->posts)
				@foreach($data['tag']->posts as $r)
				<tr>
					<td align="center">{{date('Y-m-d',strtotime($r->created_at))}}</td>
					<td>{{$r->title}}</td>
					<td>{{$r->user->name ?? ''}}</td>
					<td class="list-category">
						@isset($r->terms)
						@foreach($r->terms as $category)
							@isset($data['arrayCategory'][$category->id])
								<span class="comma"> , </span>{{$category->name}}
							@endisset
						@endforeach
						@endisset
					</td>
					<td class="list-tag">
						@isset($r->terms)
						@foreach($r->terms as $tag)
							@isset($data['arrayTag'][$tag->id])
								<span class="comma"> , </span> {{$tag->name}}
							@endif
						@endforeach
						@endisset
					</td>

					<td align="center">
						<a href="{{route('post.edit',array('post'=>$r->id))}}"><i class="fa fa-edit" title="Sửa"></i></a>
						&nbsp;&nbsp;&nbsp;
						<a style="color: red" href="#" onclick="deleteRole('destroy{{$r->id}}')"><i class="fa fa-times" title="Sửa"></i></a>
						<form id="destroy{{$r->id}}" action="{{ route('post.destroy',array('post'=>$r->id)) }}" method="post" style="display: none;">
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
<style type="text/css">

</style>
@endsection

@section('scripts')

@endsection