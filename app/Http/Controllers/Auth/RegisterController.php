<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Referral;
use App\Wallet;
use Session;
use Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	* Where to redirect users after registration.
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
		$this->middleware('guest');
	}

	/**
	* Get a validator for an incoming registration request.
	*
	* @param  array  $data
	* @return \Illuminate\Contracts\Validation\Validator
	*/
	protected function validator(array $data) {
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'max' => 'Максимально допустимая длина :max символов',
			'min' => 'Минимально допустимая длина :min символов',
			'login.unique' => 'Участник с таким логином уже зарегистрирован',
			'email' => 'Некорректный e-mail адрес',
			'email.unique' => 'Участник с таким e-mail уже зарегистрирован',
			'password_confirmation.same' => 'Пароли не совпадают',
		];

		return Validator::make($data, [
			'login' => 'required|max:255|min:2|unique:users',
			'password' => 'required|max:255|min:5',
			'password_confirmation' => 'same:password',
			'email' => 'required|email|max:255|unique:users'
		], $messages);
	}

	/**
	* Create a new user instance after a valid registration.
	*
	* @param  array  $data
	* @return User
	*/
	protected function create(array $data) {
		$user = User::create([
			'ident' => 0,
			'login' => $data['login'],
			'password' => bcrypt($data['password']),
			'email' => $data['email'],
			'refback' => 0,
			'balance' => 0,
			'date' => time(),
			'ip' => Request::ip(),
			'role' => 0,
			'hash' => Str::random(100),
		]);

		if ($user) {
			$user->update(['ident' => $user->id]);
			if (Session::has('referer.ident') AND Session::has('referer.refback')) {
				$this->setReferrals($user->ident, Session::get('referer.ident'), Session::get('referer.refback'));
				$this->setWallets($user->ident);
			}	
		}

		return $user;
	}
	
	// Запись в таблицу wallets
	protected function setWallets($ident) {
		Wallet::create(['ident' => $ident]);
	}
	
	// Запись в таблицу referrals
	protected function setReferrals($user, $referer, $refback) {
		$c = 5;

		if ($c > 0) {
			$this->saveReferrals($referer, $user, 1, $refback);
		}

		if ($c > 1) {
			for ($i = 1; $i <= $c; $i++) {
				$level = $i+1;
				$ident = Referral::where('referral', $referer)->where('level', $i)->first();
				if (!$ident) break;
				$this->saveReferrals($ident->ident, $user, $level, 0);
			}
		}
	}
	
	// INSERT в БД referrals
	protected function saveReferrals($ident, $referral, $level, $refback=0) {
		Referral::create([
			'ident' => $ident,
			'referral' => $referral,
			'level' => $level,
			'refback' => $refback,
		]);
	}

	// Переопределение вида и передача логина реферера
	public function showRegistrationForm() {
		$referer = Session::has('referer.login') ? Session::get('referer.login') : 'Отсутствует';
		return view('front.registration')->with('referer', $referer);
	}

}