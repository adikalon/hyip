<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset emails and
	| includes a trait which assists in sending these notifications from
	| your application to your users. Feel free to explore this trait.
	|
	*/

	use SendsPasswordResetEmails;

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct() {
		$this->middleware('guest');
	}

	// Перегружаем метод возвращающий вид
	public function showLinkRequestForm() {
		return view('front.repassword');
	}

	// Перегружаем метод валидации
	protected function validateEmail(Request $request) {
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'email' => 'Некорректный e-mail адрес'
		];

		$this->validate($request, ['email' => 'required|email'], $messages);
	}
}