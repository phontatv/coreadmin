<?php

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->prefix('dashboard')
	->namespace('Phobrv\CoreAdmin\Http\Controllers')->group(function () {
	Route::get('/', 'TestController@index')->name('dashboard');
});

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->prefix('admin')
	->namespace('Phobrv\CoreAdmin\Http\Controllers')->group(function () {
	Route::get('lang/{lang}', 'LanguageController@changeLang')->name('lang');

	Route::middleware(['can:super_admin'])->group(function () {
		Route::resource('user', 'UserController');
		Route::post('user/resetPass', 'UserController@resetPass')->name('user.resetPass');
		Route::resource('role', 'RoleController');
		Route::get('/permission/reimport', 'PermissionController@reimport')->name('permission.reimport');
	});

});