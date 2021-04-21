<?php

namespace Phobrv\CoreAdmin\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class TestController extends Controller {
	public function index(Request $request) {
		$user = Auth::user();
		return view('phobrv::blank')->with('user', $user);
	}
}
