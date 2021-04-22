@php
$options = [];
$options['class'] = 'form-control';
$options['rows'] = '3';
if(isset($required) && $required )
	$options['required'] = 'required';
$type = isset($type) ? $type : "";
$style = isset($style) ? $style : "full";
switch ($type) {
	case 'meta':
	$value = isset($data['meta'][$key]) ? $data['meta'][$key] : '';
	break;
	case 'configs':
	$value = isset($data['configs'][$key]) ? $data['configs'][$key] : '';
	break;
	default:
	$value = isset($data['post']->$key) ? $data['post']->$key : '';
	break;
}
@endphp
@if($style == "full")
<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label"> {{ $label }} </label>
	<div class="col-sm-10">
		{{ Form::textarea($key,$value,$options) }}
	</div>
</div>
@elseif($style == 'short')
<label>{{ $label }}</label>
{{ Form::textarea($key,$value,$options) }}
@endif