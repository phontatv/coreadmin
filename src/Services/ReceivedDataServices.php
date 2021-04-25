<?php
namespace Phobrv\CoreAdmin\Services;

class ReceivedDataServices {
	public function handelOrderData($data) {
		$data['arrayMeta']['product'] = "Name Product";
		if (isset($data['number'])) {
			$data['arrayMeta']['number'] = $data['number'];
		}
		$data['received'] = [
			'type' => $data['type'],
			'name' => $data['name'],
			'phone' => $data['phone'],
			'content' => $data['content'],
		];

		$data['title'] = "Mail thông báo đơn hàng thành công";
		$data['content'] = "Time:  " . date('H:i:s d-m-Y') .
			"<br>Tên: " . $data['name'] .
			"<br>SDT: " . $data['phone'] .
			"<br>Nội dung: " . $data['content'] .
			"<br>Sản phẩm: " . $data['product'];
		if (isset($data['number'])) {
			$data['content'] .= "<br>Số lượng: " . $data['number'];
		}
		return $data;
	}
	public function handleContactData($data) {
		$data['received'] = [
			'type' => $data['type'],
			'name' => $data['name'],
			'phone' => $data['phone'],
			'content' => $data['content'],
		];

		$data['title'] = "Mail thông báo liên hệ mới";
		$data['content'] = "Time:  " . date('H:i:s d-m-Y') .
			"<br>Tên: " . $data['name'] .
			"<br>SDT: " . $data['phone'] .
			"<br>Nội dung: " . $data['content'];
		return $data;
	}
	public function handleDataRegisSupport($data) {
		$data['received'] = [
			'type' => $data['type'],
			'content' => $data['content'],
			'name' => $data['name'],
			'phone' => $data['phone'],
		];

		$data['title'] = "Mail thông báo đăng ký tư vấn";
		$data['content'] = "Time:  " . date('H:i:s d-m-Y') .
			"<br>Tên: " . $data['name'] .
			"<br>Số điện thoại: " . $data['phone'] .
			"<br>Content: " . $data['content'];
		return $data;
	}
}
