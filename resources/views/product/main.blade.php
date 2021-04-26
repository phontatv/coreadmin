<div class="row">
	<div class="col-md-8">
		@isset($data['post'])
		<div class="row">
			<div class="col-md-6">
				@include('phobrv::input.inputSelect',['label'=>'Status','key'=>'status','array'=>['1'=>'Normal','2'=>'Hot','0'=>'Disable']])
			</div>
			<div class="col-md-6">
				@include('phobrv::input.inputText',['label'=>'Create date','key'=>'created_at','datepicker'=>true])
			</div>
		</div>
		@include('phobrv::input.inputText',['label'=>'Url','key'=>'slug'])

		@endif
		@include('phobrv::input.inputText',['label'=>'Product Name','key'=>'title'])

		{{ Form::textarea('content',old('content',(isset($data['post']) && $data['post']) ? $data['post']->content : ''),array('class'=>'form-control','rows'=>'20')) }}
	</div>
	<div class="col-md-4">
		@include('phobrv::input.inputImage',['key'=>'thumb'])
		<hr>
		<div class="form-group">
			<div class="col-sm-12">
				<label  class="font16">Groups</label>
			</div>
			@isset($data['group'])
			<ul>
				@foreach($data['group'] as $g)
				<li>
					<input type="checkbox" name="group[]" value="{{$g->id}}" @if(in_array($g->id,$data['arrayGroupID'])) checked @endif> {{$g->name}}
				</li>
				@if(isset($g->child))
				@foreach($g->child as $c)
				<li style="padding-left: 30px;">
					<input type="checkbox" name="group[]" value="{{$c->id}}" @if(in_array($c->id,$data['arrayGroupID'])) checked @endif> {{$c->name}}
				</li>
				@endforeach
				@endif
				@endforeach
			</ul>
			@endisset
		</div>
	</div>
</div>