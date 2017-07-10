<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	* Where to redirect users after login.
	*
	* @var string
	*/
	protected $redirectTo = '/';

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	/*protected function validateLogin(Request $request) {

	$this->validate($request, [
	$this->username() => 'required|string',
	'pass' => 'required|string',
	]);
	dd($request);
	}*/

	// Перегружаем поле username, по которому будет проходить аутентификация
	public function username() {
		return 'login';
	}

	// Перегружаем метод валидации
	protected function validateLogin(Request $request) {
		$messages = [
			'required' => 'Поле не должно быть пустым'
		];

		$this->validate($request, [
			$this->username() => 'required|string',
			'password' => 'required|string',
		], $messages);
	}
}