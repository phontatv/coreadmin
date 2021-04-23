<div class="box box-primary">
	<div class="box-header font16">
		<a href="#" onclick="save()"  class="btn btn-primary float-left">
			<i class="fa fa-floppy-o"></i> @lang('Save & Close')
		</a>
		<a href="#" onclick="update()"  class="btn btn-warning float-left">
			<i class="fa fa-wrench"></i> @lang('Update')
		</a>
	</div>
	<form class="form-horizontal" id="formSubmit" method="post" action="{{route('menu.update',['menu'=>$data['post']->id])}}">
		@csrf
		@isset($data['post']) @method('put') @endif
		<input type="hidden" name="typeSubmit" id="typeSubmit" value="">
		<div class="box-body">
			@isset($data['post'])
			@include('admin.input.inputSelect',['label'=>'Show','key'=>'status','default'=>'1','array'=>['0'=>'No','1'=>'Yes']])
			@endif
			@if( isset($data['post']->slug ))
			@if($data['post']->subtype == 'link')
			<input type="hidden" name="slug" value="{{$data['post']->slug}}">
			@else
			@include('admin.input.inputText',['label'=>'Url','key'=>'slug'])
			@endif
			@endif
			@include('admin.input.inputText',['label'=>'Name','key'=>'title','required'=>true])

			@if(isset($data['post']['childs']) && count($data['post']['childs']) == 0 || !isset($data['post']['childs']) )
			@include('admin.input.inputSelect',['label'=>'Parent','key'=>'parent','array'=>$data['arrayMenuParent']])
			@endif
			@include('admin.input.inputSelect',['label'=>'Template','key'=>'subtype','array'=>$templateMenu])
			@if($data['post']->subtype != 'link')
			<label>Seo Meta</label>
			@include('admin.input.inputFile',['label'=>'Thumb Meta','key'=>'thumb','width'=>'200px'])
			@include('admin.input.inputText',['label'=>'Meta Title','key'=>'meta_title','type'=>'meta'])
			@include('admin.input.inputText',['label'=>'Meta Description','key'=>'meta_description','type'=>'meta'])
			@include('admin.input.inputText',['label'=>'Meta Keywords','key'=>'meta_keywords','type'=>'meta'])
			@else
			@include('admin.input.inputText',['label'=>'Link','key'=>'excerpt','required'=>true])
			@endif
		</div>
		<button type="submit" id="btnSubmit" style="display: none;">Submit</button>
	</form>
</div>
