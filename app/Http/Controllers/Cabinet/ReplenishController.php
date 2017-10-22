<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectWallet;
use App\Replenishment;
use Auth;
use App\Classes\Helpers;

class ReplenishController extends Controller {
	
	public function index() {
		return $this->getView();
	}
	
	public function replenish(Request $request) {

		$messages = [
			'required' => 'Поле не должно быть пустым',
			'max' => 'Максимально допустимая длина :max символов',
			'min' => 'Минимально допустимая длина :min символов',
		];
		
		$this->validate($request, [
			'transaction' => 'required|min:5|max:255',
		], $messages);
		
		$this->addReplenish($request);
		
		return $this->getView('Заявка отправлена. Ожидайте подтверждение от администратора');
	}
	
	protected function addReplenish($request) {
		$wallet = explode('::n::', $request->wallet);
		
		$replenish = Replenishment::create([
			'ident' => Auth::user()->ident,
			'wallet' => $wallet[0],
			'number' => $wallet[1],
			'transaction' => $request->transaction,
			'sum' => 0,
			'status' => 0,
			'date' => Helpers::time(),
		]);
		return $replenish;
	}
	
	protected function getReplenishments() {
		$replenishment = Replenishment::where('ident', Auth::user()->ident)
			->orderBy('date', 'desc')
			->take(25)
            ->get();
            
        $replenish = [];
        
        foreach ($replenishment as $rep) {
			$sum = $rep->sum == 0 && $rep->status == 0 ? 'Неизвестно' : $rep->sum;
			if ($rep->status == 0) {
				$status = 'Ожидание';
			} else if ($rep->status == 1) {
				$status = 'Принято';
			} else if ($rep->status == 2) {
				$status = 'Отклонено';
			} else {
				$status = 'Неизвестно';
			}
			
			if ($rep->date_accepted) {
				$accepted = $rep->date_accepted;
			} else {
				$accepted = '-//-';
			}
			$replenish[] = [
	        	'name' => $rep->wallet,
	        	'sum' => $sum,
	        	'status' => $status,
	        	'transaction' => $rep->transaction,
	        	'date' => $rep->date,
	        	'accepted' => $accepted
	        ];
		}
		return $replenish;
	}
	
	protected function getView($success = false) {
		$wallets = ProjectWallet::all()->where('switch', 1);
		return view('front.cabinet.replenish')
			->with('wallets', $wallets)
			->with('replenish', $this->getReplenishments())
			->with('success', $success);
	}
	
}