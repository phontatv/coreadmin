<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->prefix('admin')->namespace('Phobrv\CoreAdmin\Http\Controllers')
	->group(function () {
		Route::get('lang/{lang}', 'LanguageController@changeLang')->name('lang');
		Route::get('/phobrv', 'TestController@index')->name('phobrv');
	});