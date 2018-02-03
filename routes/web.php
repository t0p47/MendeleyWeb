<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('testing',function(){
	return view('morris');
});


//Добавляет маршруты для Auth
Auth::routes();

//Email confirmation
Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');


Route::post('admin_login', 'AdminAuth\LoginController@login');
Route::get('admin_login', 'AdminAuth\LoginController@showLoginForm');
Route::post('admin_logout', 'AdminAuth\LoginController@logout');
Route::post('admin_password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
Route::get('admin_password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
Route::post('admin_password/reset', 'AdminAuth\ResetPasswordController@reset');
Route::get('admin_password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
Route::post('admin_register', 'AdminAuth\RegisterController@register');
Route::get('admin_register', 'AdminAuth\RegisterController@showRegistrationForm');


Route::get('/download_windows', 'HomeController@downloadWindows');

Route::get('/home', 'HomeController@index');

Route::get('admin_home','AdminHomeController@index');

Route::get('users_list','AdminHomeController@usersList');

Route::get('all_transactions/list','TransactionController@allList')->name('allTransList');

Route::get('all_transactions/chart','TransactionController@allChart')->name('allTransChart');

Route::post('/home','TransactionController@addRevenue')->name('addRevenue');

Route::post('edit_user','UserController@editUser');

Route::delete('user/delete/{user}',function(\App\User $user){
	$user->delete();
	
	return redirect('users_list');
});

Route::get('user_data/{id}','AdminHomeController@userData');

Route::post('mass_ip_restrict','AdminHomeController@massIpRestrict');

//Пользовательская библиотека(просмотр)
//TODO убрать отображение в id в get запросе
Route::get('/library/{id}','LibraryController@userLibrary')->name('GetLibrary');

//AJAX Show articles in folder
Route::post('/library/folder','LibraryController@userFolder')->name('GetFolder');

//AJAX Show all articles
Route::post('/library/all','LibraryController@allArticles');

//AJAX Show favorite articles
Route::post('/library/favorite','LibraryController@favoriteArticles');

//AJAX Show my articles
Route::post('/library/my','LibraryController@myArticles');

//AJAX Show my articles
Route::post('/library/make-favorite','LibraryController@makeArticleFavorite');

//AJAX add subfolder
Route::post('/library/addSubfolder','LibraryController@addOrRenameSubfolder');

//AJAX delete folder
Route::post('/library/deleteFolder','LibraryController@deleteFolder')->name('DeleteFolder');

Route::post('/create_journal_article','LibraryController@createJournalArticle')->name('addJournalArticle');

Route::post('/edit_journal_article','LibraryController@editJournalArticle')->name('editJournalArticle');

Route::post('/journalarticle/delete', 'LibraryController@deleteJournalArticle');

Route::get('authors_list','UserController@getAuthors')->name('GetAuthors');

Route::get('journalarticle_list', 'JournalArticleController@getAllArticles')->name('GetAllArticles');

//PDF Viewer
Route::post('view-pdf', 'JournalArticleController@viewPdf');

Route::get('/journal-article/search','JournalArticleController@showSearchPage');

Route::post('/journal-article/search','JournalArticleController@searchJournalArticle')->name('JournalArticleSearch');


//MENDELEY ROUTES
//Route::get('/library/{id}','LibraryController@userLibrary')->name('GetLibrary');
Route::get('/mendeley-library/{id}','LibraryController@userMendeleyLibrary')->name("GetLibrary");

//Get one article by id
Route::get('/journal-article/{id}','JournalArticleController@getArticleById')->name("GetArticleById");

Route::post('/search/article','LibraryController@readArticle');

Route::get('/journal/search-page','JournalController@showSearchPage');

Route::post('/search/journal','JournalController@searchJournal')->name('JournalSearch');

//Route::get('/show/journal/{id}','JournalController@showJournal');

//Route::get('/show/journal/{id}/{year}','JournalController@showJournalByYear');

Route::post('/show/journal','JournalController@showJournal');



//TODO: DELETE LATER
Route::get('/phpinfo','HomeController@phpinfo');