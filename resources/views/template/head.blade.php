<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ config('constants.site_title', 'Admin Page') }}</title>
<link rel="shortcut icon" href="@if( config('constants.site_icon') ) {{ asset('storage/'.config('constants.site_icon') ) }} @else {{ asset('favicon.ico') }} @endif">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('/vendor/phobrv/css/admin.css')}}">
<script src="{{asset('/vendor/phobrv/js/admin.js')}}"></script>
<script>
	var options = {
		filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
		filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
		filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
		filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
		height: '300px'
	};
</script>
<style type="text/css">
	ol li,ul li{
		list-style: none!important;
	}
</style>