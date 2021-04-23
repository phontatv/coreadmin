@extends('phobrv::layout.app')

@section('header')
<h1>@lang('List icon')</h1>
@endsection

@section('content')
{!! $data['body'] !!}
@endsection

@section('styles')
<style type="text/css">
	.col-md-4{
		overflow: hidden;
		border: 1px solid #ddd;
		padding: 6px;
	}
	svg{
		width: 20px;
		height: 20px;
		margin-right: 15px;
		fill:black;
	}
</style>
@endsection


@section('scripts')
@endsection