<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller {
	public function reimport() {
		if (count(config('option.permissions'))) {
			foreach (config('option.permissions') as $permission) {
				if ($permission['children']) {
					foreach ($permission['children'] as $child) {
						Permission::firstOrCreate(['name' => $child['permission'], 'guard_name' => 'web']);
					}
				} else {
					Permission::firstOrCreate(['name' => $permission['permission'], 'guard_name' => 'web']);
				}
			}
		}
	}
}
