<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});*/

$api = app('Dingo\Api\Routing\Router');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api->version('v1',function($api){
	$api->get('hello','App\Http\Controllers\LibraryController@testIndex');

	$api->get('users/{user_id}/roles/{role_name}','App\Http\Controllers\LibraryController@attachUserRole');
	$api->get('users/{user_id}/roles','App\Http\Controllers\LibraryController@getUserRole');

	$api->post('role/permission/add','App\Http\Controllers\LibraryController@attachPermission');
	$api->get('role/{roleParam}/permissions','App\Http\Controllers\LibraryController@getPermissions');

	$api->post('crash','App\Http\Controllers\FolderController@saveCrashReport');

	$api->post('authenticate','App\Http\Controllers\Auth\LoginController@authenticate');

	//Refresh token
	$api->get('refresh-token','App\Http\Controllers\Auth\LoginController@getToken');

	$api->get('android/send/fileTest','App\Http\Controllers\JournalArticleController@receiveAndroidFile');

});

$api->version('v1',['middleware' => 'api.auth'], function($api){
	$api->get('users','App\Http\Controllers\Auth\LoginController@index');
	$api->get('user','App\Http\Controllers\Auth\LoginController@show');

	//Synchronization routes
	$api->post('android/sync/folders','App\Http\Controllers\FolderController@syncAndroidFolder');

	$api->post('android/sync/articles','App\Http\Controllers\LibraryController@syncAndroidArticles');

	//TMP routes
	//http://45.76.186.7/api/android/send/folders
	$api->post('android/send/folders','App\Http\Controllers\FolderController@sendAndroidFolder');

	$api->post('android/send/articles','App\Http\Controllers\JournalArticleController@sendAndroidArticles');

	//Route::post('view-pdf', 'JournalArticleController@viewPdf');
	$api->post('download/article','App\Http\Controllers\JournalArticleController@viewPdf');

	$api->post('windows/send/file','App\Http\Controllers\JournalArticleController@receiveWindowsFile');

	$api->post('android/folder/request','App\Http\Controllers\FolderController@sendRequestBack');

	$api->post('android/article/request','App\Http\Controllers\JournalArticleController@sendRequestBack');

	$api->get('android/send/file','App\Http\Controllers\JournalArticleController@receiveAndroidFile');
	
});