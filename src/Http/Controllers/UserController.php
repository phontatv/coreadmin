<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\SendGridService;
use Phobrv\CoreAdmin\Services\UnitServices;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

	protected $userRepository;
	protected $unitService;
	protected $sendGridService;

	public function __construct(
		UserRepository $userRepository,
		UnitServices $unitService,
		SendGridService $sendGridService
	) {
		$this->userRepository = $userRepository;
		$this->unitService = $unitService;
		$this->sendGridService = $sendGridService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Users', 'href' => ''],
			]
		);
		try {
			$data['users'] = $this->userRepository->all();
			if ($data['users']) {
				for ($i = 0; $i < count($data['users']); $i++) {
					$list = $data['users'][$i]->roles;
					$stringRole = '';
					if ($list) {
						foreach ($list as $key => $value) {
							if ($key == 0) {
								$stringRole = $value->name;
							} else {
								$stringRole .= ", " . $value->name;
							}

						}
					}
					$data['users'][$i]->stringRole = $stringRole;
					$metas = $this->userRepository->getMeta($data['users'][$i]->userMetas);
					$data['users'][$i]->receive_report = isset($metas['receive_report']) ? $metas['receive_report'] : 'no';
					$data['users'][$i]->mess_report = isset($metas['mess_report']) ? $metas['mess_report'] : 'no';
				}
			}
			return view('phobrv::user.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Users', 'href' => ''],
				['text' => 'Crate User', 'href' => ''],
			]
		);

		$data['arrayRole'] = array();
		$data['roles'] = Role::all();
		return view('phobrv::user.create')->with('data', $data);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$request->validate([
			'name' => 'required',
			'email' => 'required|unique:users',
			'password' => 'required|min:8',
			'typeSubmit' => 'required',
		]);

		try {
			$userData = $request->all();
			$userData['password'] = Hash::make($request->password);
			$user = $this->userRepository->create($userData);
			$this->updateMeta($user, $request);

			$this->updateRole($user, $request->roles);

			$msg = "Create user success!";
			if ($request->typeSubmit == 'save') {
				return redirect()->route('user.index')->with('alert_success', $msg);
			} else {
				return redirect()->route('user.edit', ['user' => $user->id])->with('alert_success', $msg);
			}

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	public function resetPass(Request $request) {
		try {
			$pass = rand(12413590, 99999999);
			$user = $this->userRepository->find($request->user_id);
			$this->userRepository->update(['password' => Hash::make($pass)], $request->user_id);

			/**
			 * Send mail
			 */
			$data['layout'] = 'emails.layout';
			$data['subject'] = env('MAIL_NAME') . " report new password";
			$data['title'] = "Mail thông báo mật khẩu mới.";
			$data['content'] = "Time:  " . date('H:i:s d-m-Y') .
				"<br>New Pass: " . $pass;
			$data['tos'] = [$user->email];
			$this->sendGridService->sendMail($data);
			//End sendmail
			return $pass;

		} catch (Exception $e) {

		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		try {

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Users', 'href' => ''],
				['text' => 'Edit User', 'href' => ''],
			]
		);

		try {
			$data['post'] = $this->userRepository->find($id);
			$data['meta'] = $this->userRepository->getMeta($data['post']->userMetas);
			$arrayRole = array();
			foreach ($data['post']->roles as $r) {
				array_push($arrayRole, $r->name);
			}
			$data['arrayRole'] = $arrayRole;
			$data['roles'] = Role::all();
			return view('phobrv::user.create')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$request->validate([
			'name' => 'required',
			'email' => 'required|unique:users,email,' . $id,
		]);

		try {
			$userData = $request->all();
			$user = $this->userRepository->update($userData, $id);
			$msg = "Update user success!";

			$this->updateMeta($user, $request);

			$this->updateRole($user, $request->roles);

			if ($request->typeSubmit == 'save') {
				return redirect()->route('user.index')->with('alert_success', $msg);
			} else {
				return redirect()->route('user.edit', ['user' => $user->id])->with('alert_success', $msg);
			}
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$user = $this->userRepository->find($id);
			$this->userRepository->insertMeta($user, array('receive_report' => 'no'));
			$list = Role::all();
			foreach ($list as $r) {
				if ($user->hasRole($r->name)) {
					$user->removeRole($r->name);
				}

			}
			$msg = "DiActive user success!";
			return redirect()->route('user.index')->with('alert_success', $msg);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}
	public function updateRole($user, $roles) {
		$list = Role::all();
		foreach ($list as $r) {
			if ($r->name != 'SuperAdmin' && $user->hasRole($r->name)) {
				$user->removeRole($r->name);
			}

		}
		if ($roles) {
			foreach ($roles as $name) {
				$user->assignRole($name);
			}
		}

	}

	public function updateMeta($user, $request) {
		if (isset($request->receive_report)) {
			$this->userRepository->insertMeta($user, array('receive_report' => $request->receive_report));
		}

		if (isset($request->mess_report)) {
			$this->userRepository->insertMeta($user, array('mess_report' => $request->mess_report));
		}

		if (isset($request->mess_id)) {
			$this->userRepository->insertMeta($user, array('mess_id' => $request->mess_id));
		}

	}
}
