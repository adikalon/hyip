<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Digit;
use App\Statistic;
use App\Referral;
use App\Wallet;
use App\ReferralsLevel;
use Session;
use Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestTokenController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Classes\Helpers;

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
			'captcha' => 'Код каптчи введен неверно'
		];

		return Validator::make($data, [
			'login' => 'required|max:255|min:2|unique:users',
			'password' => 'required|max:255|min:5',
			'password_confirmation' => 'same:password',
			'email' => 'required|email|max:255|unique:users',
			'captcha' => 'required|captcha'
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
			'date' => Helpers::time(),
			'ip' => Request::ip(),
			'role' => 0,
		]);

		if ($user) {
			$user->update(['ident' => $user->id]);
			if (Session::has('referer.ident') AND Session::has('referer.refback')) {
				$this->setReferrals($user->ident, Session::get('referer.ident'), Session::get('referer.refback'));
			}
			$this->setWallets($user->ident);
			$this->setDigits($user->ident);
			$token = new RequestTokenController;
			$token->accountVerification($data['email']);
			$statistica = Statistic::first();
			$statistica->update(['registered' => $statistica->registered+1]);
		}

		return $user;
	}
	
	// Запись статистики участника в таблицу digits
	protected function setDigits($ident) {
		Digit::create([
			'ident' => $ident,
			'balance' => 0,
			'replenished' => 0,
			'invested' => 0,
			'pay_by_inv' => 0,
			'payment' => 0,
			'widthdraw' => 0,
			'actively' => 0,
			'pending' => 0,
			'pay_by_refs' => 0,
			'spent_on_refs' => 0
		]);
	}
	
	// Запись кошелька в таблицу wallets
	protected function setWallets($ident) {
		Wallet::create([
			'ident' => $ident,
			'qiwi' => NULL,
			'payeer' => NULL
		]);
	}
	
	// Запись в таблицу referrals
	protected function setReferrals($user, $referer, $refback) {
		
		// Получаем число реферальных уровней
		$c = count(ReferralsLevel::all());

		// Если реферальная система включена - заисываем первого
		if ($c > 0) {
			if (Request::ip() == $this->getIp($referer)) return;
			$this->saveReferrals($referer, $user, 1, $this->getPercent(1), $refback);
		}
		
		// Если установлен больше, чем 1 реферальный уровень - бегаем в цикле по таблице refferals - ищем рефереров
		if ($c > 1) {
			for ($i = 1; $i <= $c; $i++) {
				$level = $i+1;
				$ident = Referral::where('referral', $referer)->where('level', $i)->first();
				if (!$ident) break;
				if (Request::ip() == $this->getIp($ident->ident)) return;
				$this->saveReferrals($ident->ident, $user, $level, $this->getPercent($level), 0);
			}
		}
	}
	
	// Вернуть реферальный процент
	protected function getPercent($level) {
		$ref = ReferralsLevel::where('level', $level)->first();
		if ($ref === NULL) return 0;
		return $ref->percent;
	} 
	
	// INSERT в БД referrals
	protected function saveReferrals($ident, $referral, $level, $percent, $refback=0) {
		Referral::create([
			'ident' => $ident,
			'referral' => $referral,
			'level' => $level,
			'percent' => $percent,
			'refback' => $refback,
		]);
	}
	
	// Получить IP пользователя по его полю ident
	protected function getIp($ident) {
		$user = User::where('ident', $ident)->first();
		return $user->ip;
	}

	// Переопределение вида и передача логина реферера
	public function showRegistrationForm() {
		$referer = Session::has('referer.login') ? Session::get('referer.login') : 'Отсутствует';
		return view('front.registration')->with('referer', $referer);
	}

}