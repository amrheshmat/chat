<?php
define('Messages', 'Messages');
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::get('inbox', ['as' => 'messages.inbox', 'uses' => Messages.'\InboxController@index']);
	Route::get('sent', ['as' => 'messages.sent', 'uses' => Messages.'\InboxController@sentmessage']);
	Route::get('newmessage', ['as' => 'messages.newmessage', 'uses' => Messages.'\InboxController@sentview']);
	Route::put('newmessage', ['as' => 'messages.newmessage', 'uses' => Messages.'\InboxController@sent']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('replymessage', ['as' => 'messages.replymessage', 'uses' => Messages.'\InboxController@replymessage']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::post('calc_list', Messages.'\InboxController@allsentmessages');
	Route::post('calc_list2', Messages.'\InboxController@allsentmessages2');
});

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
