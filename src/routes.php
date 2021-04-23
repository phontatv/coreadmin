<?php

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->namespace('Phobrv\CoreAdmin\Http\Controllers')->group(function () {
	Route::get('lang/{lang}', 'LanguageController@changeLang')->name('lang');
	Route::middleware(['can:super_admin'])->prefix('dashboard')->group(function () {
		Route::get('/', 'DashboardController@index')->name('dashboard');
		Route::get('/data', 'DashboardController@data')->name('dashboard.data');
	});
	Route::middleware(['can:super_admin'])->prefix('admin')->group(function () {
		Route::resource('user', 'UserController');
		Route::post('user/resetPass', 'UserController@resetPass')->name('user.resetPass');
		Route::resource('role', 'RoleController');
		Route::get('/permission/reimport', 'PermissionController@reimport')->name('permission.reimport');
	});
});
