<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wallet;
use App\Withdraw;
use App\Digit;
use Auth;
use App\Classes\Helpers;

class WithdrawController extends Controller {
	public function index() {
		return $this->getView();
	}
	
	public function withdraw(Request $request) {
		$request['sum'] = str_replace(',', '.', $request['sum']);
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'balance' => 'На балансе недостаточно средств',
			'numeric' => 'Поле должно быть числом',
			'minwith' => 'Минимальная сумма для вывода 100',
		];
		$this->validate($request, [
			'sum' => 'required|balance|numeric|minwith',
		], $messages);
		if ($this->send($request)) {
			return $this->getView('Заявка отправлена. Ожидайте подтверждение от администратора');
		} else {
			return $this->getView('Что-то пошло не так');
		}
	}
	
	protected function send($request) {
		$wallet = explode('::n::', $request->wallet);
		$withdraw = Withdraw::create([
			'ident' => Auth::user()->ident,
			'sum' => $request->sum,
			'wallet' => $wallet[0],
			'number' => $wallet[1],
			'message' => '',
			'date' => Helpers::time(),
			'date_accepted' => NULL,
			'status' => 0,
		]);
		if ($withdraw) {
			$digits = Digit::all()->where('ident', Auth::user()->ident)->first();
			$digits->update(['balance' => $digits->balance - $request->sum]);
			return $digits;
		} else {
			return false;
		}
	}
	
	protected function getWallets() {
		$wallets = [];
		$wal = Wallet::all()->where('ident', Auth::user()->ident)->first()->toArray();
		foreach ($wal as $k => $v) {
			if($k != 'id' and $k != 'ident' and $v != NULL and $v != '') {
				$wallets[$k] = $v;
			}
		}
		return $wallets;
	}
	
	protected function getWithdraws() {
		$withdraw = Withdraw::where('ident', Auth::user()->ident)
			->orderBy('date', 'desc')
			->take(25)
            ->get();
		$withdraws = [];
		foreach ($withdraw as $wit) {
			
			if ($wit->status == 0) {
				$status = 'Ожидание';
			} else if ($wit->status == 1) {
				$status = 'Выплачено';
			} else if ($wit->status == 2) {
				$status = 'Отклонено';
			} else {
				$status = 'Неизвестно';
			}
			
			if ($wit->date_accepted) {
				$accepted = $rep->date_accepted;
			} else {
				$accepted = '-//-';
			}
			
			$withdraws[] = [
	        	'date' => $wit->date,
	        	'accepted' => $accepted,
	        	'sum' => $wit->sum,
	        	'wallet' => $wit->wallet,
	        	'number' => $wit->number,
	        	'message' => $wit->message,
	        	'status' => $status
	        ];
		}
		return $withdraws;
	}
	
	protected function getView($success = false) {
		return view('front.cabinet.withdraw')
			->with('wallets', $this->getWallets())
			->with('withdraws', $this->getWithdraws())
			->with('success', $success);
	}
}