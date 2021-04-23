@extends('phobrv::layout.app')
@section('header')
<h1>
	@lang('Report website')
</h1>
@endsection
@section('content')
<div id="data" >

</div>
@endsection

@section('styles')
<style type="text/css">
	#chart-report .info-box-icon{
		height: 60px;
		width: 60px;
		line-height: 60px;
	}
	#chart-report .info-box{
		min-height: 60px;
	}
	.info-box-content{
		margin-left: 60px;
	}
	.info-box-text{
		text-transform: none;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript">

	$(document).ready(function(){
		getData()
	})

	function getData(){
		$.ajax(
		{
			url: '{{ route('dashboard.data') }}',
			type: "get",
			datatype: "html"
		}).done(function(data){
			$("#dta").empty().html(data);
		}).fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});
	}
</script>
@endsection
