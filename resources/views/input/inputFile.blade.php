@php
$type = isset($type) ? $type : "";
$width = isset($width) ? $width : "200px";
$id = '#'.$key;
$dataInput = "input".$key;

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
<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label">{{$label}}</label>
	<div class="col-sm-4">
		<div class="input-group">
			<span class="input-group-btn">
				<a id="{{ $key }}" data-input="{{ $dataInput }}" data-preview="holder" class="btn btn-primary">
					<i class="fa fa-picture-o"></i> Choose
				</a>
			</span>
			<input id="{{ $dataInput }}" class="form-control inputfile" type="text" name="{{ $key }}" value="{{ $value }}">
		</div>
		<img id="holder" style="margin-top:15px;max-height:100px;">
	</div>
	<div class="col-sm-6">
		<img class="{{ $key }}"  src="@if(isset($value) && $value != ''){{$value}}@endif" style="width: {{ $width }};height: auto;">		
	</div>
</div>
<script type="text/javascript">
	$('{{ $id }}').filemanager('images');
</script>