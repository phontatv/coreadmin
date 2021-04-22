@php
$id = '#'.$key;
$dataInput = "input".$key;
$type = isset($type) ? $type : "";
$width =  isset($width) ? $width : "100%";
switch ($type) {
	case 'meta':
	$value = isset($data['meta'][$key]) ? $data['meta'][$key] : '';
	break;
	case 'configs':
	$value = isset($data['configs'][$key]) ? $data['configs'][$key] : '';
	break;
	case 'user':
	$value = isset($data['user']->$key) ? $data['user']->$key : '';
	break;
	default:
	$value = isset($data['post']->$key) ? $data['post']->$key : '';
	break;
}
@endphp
<div class="input-group">
	<span class="input-group-btn">
		<a id="{{ $key }}" data-input="{{ $dataInput }}" data-preview="holder" class="btn btn-primary">
			<i class="fa fa-picture-o"></i> Choose
		</a>
	</span>
	<input id="{{ $dataInput }}" class="form-control inputfile" type="text" name="{{ $key }}" value="{{ $value }}">
</div>
<img id="holder" style="margin-top:15px;max-height:100px;">
@if(isset($value) && $value != '' && !isset($basic))
<div class="form-group">
	<div class="col-sm-12">
		<img src="{{$value}}" style="width: {{ $width }};height: auto;">
	</div>
</div>
@endif
<script type="text/javascript">
	$('{{ $id }}').filemanager('images');
</script>