@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Config website')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-2">
		<ul class="nav nav-pills nav-stacked">
			@include('phobrv::input.navTab',['id'=>'box1','title'=>'Main Config','active'=>'active'])
			@include('phobrv::input.navTab',['id'=>'box2','title'=>'Main Info'])
			@include('phobrv::input.navTab',['id'=>'box3','title'=>'Header/Footer'])
			@include('phobrv::input.navTab',['id'=>'box4','title'=>'Social'])
			@include('phobrv::input.navTab',['id'=>'box5','title'=>'Code Insert'])
			@include('phobrv::input.navTab',['id'=>'box6','title'=>'Robots.txt'])
			@include('phobrv::input.navTab',['id'=>'box7','title'=>'Customize.css'])
			@include('phobrv::input.navTab',['id'=>'box8','title'=>'Htaccess'])
		</ul>
	</div>
	<div class="col-xs-10">
		<div class="tab-content">
			@include('phobrv::input.tabContent',['id'=>'box1','view'=>'phobrv::config.web.mainconfig','active'=>'active'])
			@include('phobrv::input.tabContent',['id'=>'box2','view'=>'phobrv::config.web.mainInfo'])
			@include('phobrv::input.tabContent',['id'=>'box3','view'=>'phobrv::config.web.header'])
			@include('phobrv::input.tabContent',['id'=>'box4','view'=>'phobrv::config.web.social'])
			@include('phobrv::input.tabContent',['id'=>'box5','view'=>'phobrv::config.web.code_insert'])
			@include('phobrv::input.tabContent',['id'=>'box6','view'=>'phobrv::config.web.robots'])
			@include('phobrv::input.tabContent',['id'=>'box7','view'=>'phobrv::config.web.customize_css'])
			@include('phobrv::input.tabContent',['id'=>'box8','view'=>'phobrv::config.web.htaccess'])
		</div>
	</div>
</div>

@endsection

@section('styles')

@endsection

@section('scripts')
@include('phobrv::config.jsConfigForm')
@endsection