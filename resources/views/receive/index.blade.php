@extends('phobrv::layout.app')

@section('header')
<ul>
	<li>
	</li>
	<li>
		{{ Form::open(array('route'=>'receive.setDefaultSelect','method'=>'post')) }}
		<table class="form" width="100%" border="0" cellspacing="1" cellpadding="1">
			<tbody>
				<tr>
					<td style="text-align:center; padding-right: 10px;">
						<div class="form-group">
							{{ Form::select('select',$data['listReceiveType'],(isset($data['select']) ? $data['select'] : '0'),array('class'=>'form-control')) }}
						</div>
					</td>
					<td style="text-align:center; padding-right: 10px;">
						<div class="form-group">
							{{ Form::select('select_status',$orderStatus,(isset($data['select_status']) ? $data['select_status'] : '0'),array('class'=>'form-control')) }}
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
					<th>#</th>
					<th>Date</th>
					<th>Info</th>
					<th>Content</th>
					<th class="text-center">Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@isset($data['dataes'])
				@foreach($data['dataes'] as $r)
				<tr>
					<td align="center">{{$loop->index+1}}</td>
					<td>{{$r->created_at}}</td>
					<td>
						@isset($r->name)
						Name: {{$r->name}} <br>
						@endif
						@isset($r->phone)
						Phone: {{$r->phone}} <br>
						@endif
						@isset($r->add)
						Add: {{$r->add}} <br>
						@endif
						@isset($r->title)
						Title: {{$r->title}} <br>
						@endif
					</td>
					<td>{{$r->content}}</td>
					<td align="center" style="font-weight: bold;">
						<span style="color: @if($r->status == 'pendding') orange @elseif($r->status == 'success') green @else red @endif  ">
							{{$orderStatus[$r->status]}}
						</span>
					</td>
					<td align="center">
						<a href="{{route('receive.updateStatus',array('id'=>$r->id,'status'=>'success'))}}" style="color: green;">
							<i class="fa fa-check" title="Success"></i>
						</a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{route('receive.updateStatus',array('id'=>$r->id,'status'=>'fail'))}}" style="color: red;">
							<i class="fa fa-ban" title="Fail"></i>
						</a>

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

@endsection