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

	//Manager Config
	Route::middleware(['can:config_manage'])->prefix('admin')->group(function () {
		Route::get('/config-website', 'ConfigController@website')->name('config.website');
		Route::get('/config-widget', 'ConfigController@widget')->name('config.widget');
		Route::post('/config/update', 'ConfigController@update')->name('config.update');

		Route::post('/config-website/maintenanceWebsite', 'ConfigAPIController@maintenanceWebsite')->name('config.maintenanceWebsite');
		Route::post('/configAPI/update', 'ConfigAPIController@update')->name('configAPI.update');
		Route::post('/configAPI/uploadFile', 'ConfigAPIController@uploadFile')->name('configAPI.uploadFile');
		Route::get('/config-icon', 'ConfigController@showIcon')->name('config.showIcon');

	});

	Route::middleware(['can:album_manage'])->prefix('admin')->group(function () {
		Route::resource('term/albumgroup', 'TermController');
		Route::resource('{id}/album', 'AlbumController');
		Route::get('{id}/album/{album}/delete', 'AlbumController@delete')->name('album.delete');
		Route::get('{id}/album/{image}/{type}', 'AlbumController@changeOrder')->name('album.changeOrder');
		Route::post('{id}/album/updataImages', 'AlbumController@updataImages')->name('album.updataImages');
	});

	Route::middleware(['can:video_manage'])->prefix('admin')->group(function () {
		Route::resource('term/videogroup', 'TermController');
		Route::resource('video', 'VideoController');
		Route::post('/video/updateVideoGroupSelect', 'VideoController@updateVideoGroupSelect')->name('video.updateVideoGroupSelect');
		Route::get('/video/setVideoGroupSelect/{id}', 'VideoController@setVideoGroupSelect')->name('video.setVideoGroupSelect');

		Route::get('video/delete/{id}', 'VideoController@delete')->name('video.delete');
		Route::get('video/{video}/{type}', 'VideoController@changeOrder')->name('video.changeOrder');
	});

	Route::middleware(['can:question_manage'])->prefix('admin')->group(function () {
		Route::resource('term/questiongroup', 'TermController');

		Route::resource('question', 'QuestionController');
		Route::post('/question/updateQuestionGroupSelect', 'QuestionController@updateQuestionGroupSelect')->name('question.updateQuestionGroupSelect');
		Route::get('/question/setQuestionGroupSelect/{id}', 'QuestionController@setQuestionGroupSelect')->name('question.setQuestionGroupSelect');

		Route::get('question/delete/{id}', 'QuestionController@delete')->name('question.delete');

	});

	Route::middleware(['can:customeridea_manage'])->prefix('admin')->group(function () {
		Route::resource('customeridea', 'CustomerIdeaController');
	});

	Route::middleware(['can:post_manage'])->prefix('admin')->group(function () {
		Route::resource('term/category', 'TermController');
		Route::resource('term/tag', 'TermController');
		Route::get('/tag/{tag}/list-post', 'TermController@listPostOfTag')->name('post.listPostOfTag');

		Route::resource('post', 'PostController');
		Route::get('getData', 'PostController@getData')->name('post.getData');

		Route::post('/post/tagSearchAjax', 'PostController@tagSearchAjax')->name('post.tagSearchAjax');
		Route::post('/post/updateUserSelectCategory', 'PostController@updateUserSelectCategory')->name('post.updateUserSelectCategory');
		Route::post('/post/autoCreatePostDraft', 'PostController@autoCreatePostDraft')->name('post.autoCreatePostDraft');
		Route::post('/post/autoUpdatePostContent', 'PostController@autoUpdatePostContent')->name('post.autoUpdatePostContent');
		Route::post('/post/changeStatus', 'PostController@changeStatus')->name('post.changeStatus');

	});

	Route::middleware(['can:receive_manage'])->prefix('admin')->group(function () {
		Route::resource('receive', 'ReceiveDataController');
		Route::post('/receive/setDefaultSelect', 'ReceiveDataController@setDefaultSelect')->name('receive.setDefaultSelect');
		Route::get('/receive/updateStatus/{id}/{status}', 'ReceiveDataController@updateStatus')->name('receive.updateStatus');

	});
});
