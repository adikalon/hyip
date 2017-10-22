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

Route::get('/', 'IndexController@index')->name('index');

Route::get('/r/{referer}', 'IndexController@referer');



/* -------------------------------------- Auth::routes() ------------------------------------ */
/* ------------------------------------------------------------------------------------------ */
/* ------------------------------------------------------------------------------------------ */
//Auth::routes();
// Authentication Routes...
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('auth');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('acceptrepassword');

//Route::get('/home', 'HomeController@index')->name('home');
/* ------------------------------------------------------------------------------------------ */
/* ------------------------------------------------------------------------------------------ */
/* ------------------------------------ end Auth::routes() ---------------------------------- */

//Route::get('/reverification', 'RequestTokenController@reSendEmail')->name('reverification');

Route::group(['prefix'=>'cabinet', 'middleware'=>['auth', 'verification', 'investmentprocessing']], function () {
	Route::get('/', 'Cabinet\CabinetController@index')->name('cabinet');
	Route::post('/', 'Cabinet\CabinetController@index')->name('forreverification');
	Route::get('/settings', 'Cabinet\SettingsController@index')->name('settings');
	Route::post('/settings', 'Cabinet\SettingsController@request')->name('post.settings');
	Route::get('/referrals', 'Cabinet\ReferralsController@index')->name('referrals');
	Route::get('/referral/{token}', 'Cabinet\ReferralsController@getReferralInfo')->name('referral');
	Route::get('/replenish', 'Cabinet\ReplenishController@index')->name('replenish');
	Route::post('/replenish', 'Cabinet\ReplenishController@replenish')->name('post.replenish');
	Route::get('/invest', 'Cabinet\InvestController@index')->name('invest');
	Route::post('/invest', 'Cabinet\InvestController@invest')->name('post.invest');
	Route::get('/withdraw', 'Cabinet\WithdrawController@index')->name('withdraw');
	Route::post('/withdraw', 'Cabinet\WithdrawController@withdraw')->name('post.withdraw');
});

Route::group(['prefix'=>'admin', 'middleware'=>'adminaccess'], function () {
	Route::get('/', 'Admin\AdminController@index')->name('admin');
});

Route::get('account/verification/{token}', 'ResponseTokenController@accountVerification')->middleware('noverification')->name('account.verification');