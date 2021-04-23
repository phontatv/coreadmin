<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\UnitServices;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {
	protected $userRepository;
	protected $unitService;

	public function __construct(
		UserRepository $userRepository,
		UnitServices $unitService
	) {
		$this->userRepository = $userRepository;
		$this->unitService = $unitService;
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
				['text' => 'Roles', 'href' => ''],
			]
		);

		try {
			$data['roles'] = Role::all();
			if ($data['roles']) {
				foreach ($data['roles'] as $k => $role) {
					$stringPermission = '';
					foreach ($role->permissions as $key => $p) {
						if ($key == 0) {
							$stringPermission = $p->name;
						} else {
							$stringPermission .= ", " . $p->name;
						}
					}
					$data['roles'][$k]->stringPermission = $stringPermission;
				}
			}
			return view('phobrv::role.index')->with('data', $data);

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
				['text' => 'Roles', 'href' => ''],
				['text' => 'Create role', 'href' => ''],
			]
		);

		$data['arrayPermission'] = array();

		return view('phobrv::role.create')->with('data', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$request->validate([
			'name' => 'required|unique:roles',
		]);

		try {
			$role = new Role;
			$role->name = $request->name;
			$role->guard_name = 'web';
			$role->save();
			$this->updateRole($role, $request->permissions);
			$msg = "Create role success!";
			if ($request->typeSubmit == 'save') {
				return redirect()->route('role.index')->with('alert_success', $msg);
			} else {
				return redirect()->route('role.edit', ['role' => $role->id])->with('alert_success', $msg);
			}

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
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
				['text' => 'Roles', 'href' => ''],
				['text' => 'Edit role', 'href' => ''],
			]
		);

		try {
			$data['role'] = Role::find($id);
			$arrayPermission = array();

			foreach ($data['role']->permissions as $key => $p) {
				array_push($arrayPermission, $p->name);
			}
			$data['arrayPermission'] = $arrayPermission;

			return view('phobrv::role.create')->with('data', $data);

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
			'name' => 'required|unique:roles,name,' . $id,
		]);

		try {
			$role = Role::find($id);
			$role->name = $request->name;
			$role->guard_name = 'web';
			$role->save();

			$this->updateRole($role, $request->permissions);

			$msg = "Update role success!";
			if ($request->typeSubmit == 'save') {
				return redirect()->route('role.index')->with('alert_success', $msg);
			} else {
				return redirect()->route('role.edit', ['role' => $role->id])->with('alert_success', $msg);
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
		$role = Role::find($id);
		if ($role->name != "Super Admin") {
			$role->delete();
			$msg = "Delete role success!";
			return redirect()->route('role.index')->with('alert_success', $msg);
		} else {
			$msg = "You don't remove 'Super Admin' role";
			return redirect()->route('role.index')->with('alert_warning', $msg);
		}
	}

	public function updateRole($role, $permissions) {
		//reset all permission
		$list = Permission::all();
		foreach ($list as $p) {
			$role->revokePermissionTo($p);
		}

		//reAdd permissions
		if ($permissions) {
			foreach ($permissions as $key => $value) {
				// dd(Permission::where(['name' => $value])->first());
				$role->givePermissionTo(Permission::where(['name' => $value])->first());
			}
		}

	}

}
