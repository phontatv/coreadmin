<?php

return [
	'paginate' => '5',
	'theme' => 'theme1',
	'robots_file' => '/robots.txt',
	'htaccess_file' => '/.htaccess',
	'customize_css_file' => '/css/customize.css',
	'http_type' => env('HTTP_TYPE', 'http'),
	'post_type' => [
		'post' => 'post',
		'image' => 'image',
		'menu_item' => 'menu_item',
		'video' => 'video',
		'question' => 'question',
		'customeridea' => 'customeridea',
		'drugstore' => 'drugstore',
		'product' => 'product',
	],
	'recieve_status' => [
		'success' => '1',
		'pending' => '0',
		'fail' => '-1',
	],
	'post_status' => [
		'publish' => '1',
		'private' => '0',
		'draft' => '-1',
	],
	'taxonomy' => [
		'category' => 'category',
		'tag' => 'tag',
		'menugroup' => 'menugroup',
		'albumgroup' => 'albumgroup',
		'videogroup' => 'videogroup',
		'questiongroup' => 'questiongroup',
		'region' => 'region',
		'brand' => 'brand',
		'product' => 'product',
	],
	'crawler_source_type' => [
		'rss' => 'RSS',
		'category' => 'Category',
		'post' => 'Post',
	],
	'crawler_data_status' => [
		'-3' => 'Draf',
		'-2' => 'Pendding',
		'-1' => 'Fail',
		'1' => 'Success',
	],
	'permissions' => [
		[
			'name' => 'View report in the Dashboard',
			'permission' => 'view_report',
			'children' => [],
		],
		[
			'name' => 'Manage Profile',
			'permission' => 'profile_manage',
			'children' => [],
		],

		[
			'name' => 'Manage Post',
			'permission' => 'post_manage',
			'children' => [],
		],

		[
			'name' => 'Manage Menu',
			'permission' => 'menu_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Album',
			'permission' => 'album_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Video',
			'permission' => 'video_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Question',
			'permission' => 'question_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Customer Idea',
			'permission' => 'customeridea_manage',
			'children' => [],
		],
		[
			'name' => 'Manage DrugStore',
			'permission' => 'drugstore_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Product',
			'permission' => 'product_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Config',
			'permission' => 'config_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Order',
			'permission' => 'order_manage',
			'children' => [],
		],
		[
			'name' => 'Manage Receive Data',
			'permission' => 'receive_manage',
			'children' => [],
		],

	],
]

;?>