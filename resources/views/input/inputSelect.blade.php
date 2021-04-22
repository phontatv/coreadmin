@php
$type = isset($type) ? $type : "";
$options['class'] = 'form-control';
$default = isset($default) ? $default : 0;
switch ($type) {
	case 'meta':
	$value = isset($data['meta'][$key]) ? $data['meta'][$key] : $default;
	break;
	case 'configs':
	$value = isset($data['configs'][$key]) ? $data['configs'][$key] : '';
	break;
	default:
	$value = isset($data['post']->$key) ? $data['post']->$key : $default;
	break;
}
@endphp
<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label">{{ $label }}</label>
	<div class="col-sm-10">
		{{Form::select($key, $array,$value,$options)}}
		@if (isset($errors) && $errors->has($key))
		<span class="invalid-feed" role="alert">
			<strong>{{ $errors->first($key) }}</strong>
		</span>
		@endif
	</div>
</div>