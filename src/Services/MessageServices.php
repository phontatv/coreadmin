<?php
namespace Phobrv\CoreAdmin\Services;

class MessageServices {
	public function genMessage($object, $action) {
		$msg = "";
		switch ($object . "." . $action) {
		case 'category.store':
			$msg = __('Create category success!');
			break;
		case 'category.update':
			$msg = __('Update category success!');
			break;
		case 'category.destroy':
			$msg = __('Delelte category success!');
			break;
		case 'tag.store':
			$msg = __('Create tag success!');
			break;
		case 'tag.update':
			$msg = __('Update tag success!');
			break;
		case 'tag.destroy':
			$msg = __('Delelte tag success!');
			break;
		case 'video.store':
			$msg = __('Create video group success!');
			break;
		case 'video.update':
			$msg = __('Update video group success!');
			break;
		case 'video.destroy':
			$msg = __('Delelte video group success!');
			break;
		default:
			$msg = __('No message');
			break;
		}
		return $msg;
	}
}