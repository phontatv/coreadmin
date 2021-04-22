@php
$options = [];
$options['placeholder'] = $label;
$options['class'] = 'form-control';
if(isset($datepicker) && $datepicker)
	$options['class'] = 'form-control datepicker';
if(isset($required) && $required )
	$options['required'] = 'required';
if(isset($readonly) && $readonly )
	$options['readonly'] = 'readonly';

$type = isset($type) ? $type : "";
$inputType = isset($inputType) ? $inputType : "text";
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
<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label"> {{ $label }} </label>
	<div class="col-sm-10">
		@if($inputType == 'text')
		{{ Form::text($key,$value,$options) }}
		@elseif($inputType == 'number')
		{{ Form::number($key,$value,$options) }}
		@endif
		@if (isset($errors) && $errors->has($key) )
		<span class="invalid-feed" role="alert">
			<strong>{{ $errors->first($key) }}</strong>
		</span>
		@endif
	</div>
</div>
