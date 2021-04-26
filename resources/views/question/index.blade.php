@extends('phobrv::layout.app')

@section('header')
<ul>
	<li>
		<a href="{{route('questiongroup.index')}}"  class="btn btn-default float-left">
			<i class="fa fa-backward"></i> @lang('Back')
		</a>
	</li>
	<li>
		<a href="{{route('question.create')}}"  class="btn btn-primary float-left">
			<i class="fa fa-floppy-o"></i> Create
		</a>
	</li>
	<li>
		<form method="post" action="{{route('question.updateQuestionGroupSelect')}}">
			@csrf
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
								<button id="btnSubmitFilter" class="btn btn-primary ">{{__('Get')}}</button>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</li>
</ul>



@endsection

@section('content')

	<div class="box  box-primary">
		<div class="box-header">
			{{__('List Question')}}
		</div>
		<div class="box-body">
			<table  class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Question</th>
						<th>Date</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@isset($data['questions'])
						@foreach($data['questions'] as $p)
							<tr>
								<td>{{$loop->index+1}}</td>
								<td>{{$p->title}}</td>
								<td>{{$p->excerpt}}</td>
								<td>{{date('Y-m-d',strtotime($p->created_at))}}</td>
								<td align="center" style="vertical-align: middle;">
									<a href="{{route('question.edit',array('question'=>$p->id))}}">
										<i class="fa fa-edit" title="Sửa"></i>
									</a>
									&nbsp;&nbsp;&nbsp;
									<a style="color: red" href="javascript:void(0)" onclick="destroy('{{ route('question.delete',array('id'=>$p->id)) }}')">
										<i class="fa fa-times" title="Delete"></i>
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
<script type="text/javascript">
	function destroy(url) {
		var anwser =  confirm("Bạn muốn xóa question này?");
		if(anwser){
			window.location=url;
		}
	}
	function updateImages()
	{
		$('#formImages').submit();
	}
</script>
@endsection