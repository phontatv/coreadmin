@extends('phobrv::layout.app')

@section('header')
<h1>@lang('Config website')</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-2">
		<ul class="nav nav-pills nav-stacked">
			@include('admin.input.navTab',['id'=>'box1','title'=>'Main Config','active'=>'active'])
			@include('admin.input.navTab',['id'=>'box2','title'=>'Main Info'])
			@include('admin.input.navTab',['id'=>'box3','title'=>'Header/Footer'])
			@include('admin.input.navTab',['id'=>'box4','title'=>'Social'])
			@include('admin.input.navTab',['id'=>'box5','title'=>'Code Insert'])
			@include('admin.input.navTab',['id'=>'box6','title'=>'Robots.txt'])
			@include('admin.input.navTab',['id'=>'box7','title'=>'Customize.css'])
			@include('admin.input.navTab',['id'=>'box8','title'=>'Htaccess'])
		</ul>
	</div>
	<div class="col-xs-10">
		<div class="tab-content">
			@include('admin.input.tabContent',['id'=>'box1','view'=>'admin.config.web.mainconfig','active'=>'active'])
			@include('admin.input.tabContent',['id'=>'box2','view'=>'admin.config.web.mainInfo'])
			@include('admin.input.tabContent',['id'=>'box3','view'=>'admin.config.web.header'])
			@include('admin.input.tabContent',['id'=>'box4','view'=>'admin.config.web.social'])
			@include('admin.input.tabContent',['id'=>'box5','view'=>'admin.config.web.code_insert'])
			@include('admin.input.tabContent',['id'=>'box6','view'=>'admin.config.web.robots'])
			@include('admin.input.tabContent',['id'=>'box7','view'=>'admin.config.web.customize_css'])
			@include('admin.input.tabContent',['id'=>'box8','view'=>'admin.config.web.htaccess'])
		</div>
	</div>
</div>

@endsection

@section('styles')

@endsection

@section('scripts')
@include('admin.config.jsConfigForm')
@endsection