<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\UserRepository;

class LanguageController extends Controller {
	protected $userRepository;
	private $langActive = [
		'vi',
		'en',
	];

	public function __construct(UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	public function changeLang(Request $request, $lang) {
		$user = Auth::user();
		if (in_array($lang, $this->langActive)) {
			$this->userRepository->insertMeta($user, array('admin_locale' => $lang));
			return redirect()->back();
		}
	}
}
