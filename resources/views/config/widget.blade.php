@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Config widgets')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-3">
		<ul class="nav nav-pills nav-stacked">
			@include('phobrv::input.navTab',['id'=>'box1','title'=>'Fanpage','active'=>'active'])
			@include('phobrv::input.navTab',['id'=>'box2','title'=>'Bài viết phổ biến'])
		</ul>
	</div>
	<div class="col-xs-9">
		<div class="tab-content">
			@include('phobrv::input.tabContent',['id'=>'box1','view'=>'phobrv::config.component.fanpage','active'=>'active'])
			@include('phobrv::input.tabContent',['id'=>'box2','view'=>'phobrv::config.component.popularpost'])
		</div>
	</div>
</div>
@endsection

@section('styles')

@endsection


@section('scripts')
@include('phobrv::config.jsConfigForm')
@endsection