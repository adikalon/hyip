<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	* Where to redirect users after resetting their password.
	*
	* @var string
	*/
	protected $redirectTo = '';

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct() {
		$this->middleware('guest');
		$this->redirectTo = route('cabinet');
	}

	// Правила валидации
	protected function rules() {
		return [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:5',
			'password_confirmation' => 'same:password',
		];
	}

	// Сообщения валидации
	protected function validationErrorMessages() {
		return [
			//'token.required' => 'Неправильная либо устаревшая ссылка',
			'required' => 'Поле не должно быть пустым',
			'email' => 'Некорректный e-mail адрес',
			'min' => 'Минимально допустимая длина :min символов',
			'password_confirmation.same' => 'Пароли не совпадают',
		];
	}

	// Перегружаем метод возвращающий вид
	public function showResetForm(Request $request, $token = null) {
		return view('front.acceptrepassword')->with(
			['token' => $token, 'email' => $request->email]
		);
	}
}