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

	//Manager Menu
	Route::middleware(['can:menu_manage'])->prefix('admin')->group(function () {
		Route::resource('term/menugroup', 'TermController');
		Route::resource('menu', 'MenuController');
		Route::get('/menu/setMenuGroupSelect/{id}', 'MenuController@setMenuGroupSelect')->name('menu.setMenuGroupSelect');

		Route::post('/menu/updateContent/{menu}', 'MenuController@updateContent')->name('menu.updateContent');

		Route::post('/menu/updateUserSelectMenu', 'MenuController@updateUserSelectMenu')->name('menu.updateUserSelect');
		Route::get('/menu/changeOrder/{menu}/{type}', 'MenuController@changeOrder')->name('menu.changeOrder');
		Route::post('/menu/updateMultiMeta/{id}', 'MenuController@updateMultiMeta')->name('menu.updateMultiMeta');
		Route::post('/menu/updateMeta/{menu}', 'MenuController@updateMeta')->name('menu.updateMeta');
		Route::post('/menu/removeMeta', 'MenuController@removeMeta')->name('menu.removeMeta');

		//Api
		Route::post('/menu/updateMetaAPI', 'MenuController@updateMetaAPI')->name('menu.updateMetaAPI');
		Route::post('/menu/uploadFileAPI', 'MenuController@uploadFileAPI')->name('menu.uploadFileAPI');

	});

});
