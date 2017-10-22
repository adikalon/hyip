<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller {
	
	public function index() {
		return view('front.cabinet.settings')
			->with('set', $this->getSettings())
			->with('wallet', $this->getWallets());
	}
	
	public function request(Request $request) {
		switch($request['role']) {
			case 'set': return $this->setSet($request);
			case 'email': return $this->setEmail($request);
			case 'pass': return $this->setPassword($request);
		}
	}
	
	protected function setSet($request) {
		if ($request['qiwi'] === NULL) $request['qiwi'] = '';
		if ($request['payeer'] === NULL) $request['payeer'] = '';
		$request['refback'] = str_replace(',', '.', $request['refback']);
		
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'max' => 'Максимально допустимая длина :max символов',
			'min' => 'Минимально допустимая длина :min символов',
			'login.unique' => 'Такой логин занят',
			'numeric' => 'Некорректный формат',
			'between' => 'Рефбек от 0 до 100',
			'regex' => 'Некорректный формат',
		];

		$this->validate($request, [
			'login' => [
				'required',
				'max:255',
				'min:2',
				Rule::unique('users')->ignore(Auth::user()->id),
			],
			'refback' => 'required|numeric|between:0,100',
			'qiwi' => 'regex:/^(\+?[0-9]{10,13})?$/',
			'payeer' => 'regex:/^(P[0-9]{8})?$/',
		], $messages);
		
		$this->setSettings($request);
		$this->setWallets($request);

		return $this->returnSuccessData('Данные успешно изменены');
	}
	
	protected function setEmail($request) {
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'email' => 'Некорректный формат',
			'unique' => 'Email уже кем-то используется'
		];

		$this->validate($request, [
			'email' => [
				'required',
				'email',
				Rule::unique('users')->ignore(Auth::user()->id),
			]
		], $messages);
		
		$this->setSettingsEmail($request);

		return $this->returnSuccessData('Данные успешно изменены. Необходима повторная верификация');
	}
	
	protected function setPassword($request) {
		
		$messages = [
			'pass' => 'Введен неверный пароль',
			'required' => 'Поле не должно быть пустым',
			'max' => 'Максимально допустимая длина :max символов',
			'min' => 'Минимально допустимая длина :min символов',
			'newpassword_confirmation.same' => 'Пароли не совпадают',
		];

		$this->validate($request, [
			'password' => 'pass',
			'newpassword' => 'required|max:255|min:5',
			'newpassword_confirmation' => 'same:newpassword',
		], $messages);
		
		$this->setSettingsPassword($request);

		return $this->returnSuccessData('Пароль изменен');
	}
	
	protected function getSettings() {
		$ident = Auth::user()->ident;
		$settings = User::all()->where('ident', $ident)->first();
		return $settings;
	}
	
	protected function getWallets() {
		$ident = Auth::user()->ident;
		$wallets = Wallet::all()->where('ident', $ident)->first();
		return $wallets;
	}
	
	protected function setSettings($data) {
		$this->getSettings()->update([
			'login' => $data['login'],
			'refback' => $data['refback']
		]);
	}
	
	protected function setWallets($data) {
		$this->getWallets()->update([
			'qiwi' => $data['qiwi'],
			'payeer' => $data['payeer']
		]);
	}
	
	protected function setSettingsEmail($data) {
		if ($data['email'] != Auth::user()->email) {
			$this->getSettings()->update([
				'email' => $data['email'],
				'role' => 0
			]);
		}
	}
	
	protected function setSettingsPassword($data) {
		$this->getSettings()->update([
			'password' => Hash::make($data['newpassword'])
		]);
	}
	
	protected function returnSuccessData($text) {
		return view('front.cabinet.settings')
			->with('set', $this->getSettings())
			->with('wallet', $this->getWallets())
			->with('success', $text);
	}
	
}