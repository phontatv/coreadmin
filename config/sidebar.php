<?php

return [
	'menu' => [

		[
			'id' => 'menu-dashboard',
			'title' => 'Dashboard',
			'icon' => 'fa fa-dashboard',
			'href' => 'admin/dashboard',
			'permissions' => ['view_report'],
			'children' => [],
		],
		[
			'id' => 'menu-account',
			'title' => 'Accounts',
			'icon' => 'fa fa-user',
			'href' => '',
			'permissions' => ['super_admin'],
			'children' => [
				[
					'id' => '',
					'title' => 'Users',
					'icon' => 'fa-building-o',
					'href' => 'admin/user',
					'permissions' => [],
					'children' => [],
				],
				[
					'id' => '',
					'title' => 'Roles',
					'icon' => 'fa-building-o',
					'href' => 'admin/role',
					'permissions' => [],
					'children' => [],
				],
			],
		],
	],
];