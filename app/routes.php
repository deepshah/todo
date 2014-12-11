<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/login', function() {
    return View::make('login', array(
      'authUrl' => Auth::getAuthUrl()
    ));
});

Route::get('/logout', function() {
    Auth::logout();
    return Redirect::to('/');
});

Route::get('/', function()
{
	return Redirect::to('/tasks');
});

Route::group(array('before' => array('google-finish-authentication', 'auth')), function() {
    Route::resource('/tasks', 'TaskController');
    Route::resource('/tasks/comments', 'CommentController');
    Route::get('/archives', 'ArchiveController@index');
});
