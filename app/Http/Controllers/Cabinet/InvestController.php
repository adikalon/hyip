<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Rate;
use App\Invest;
use App\Digit;
use App\Statistic;
use App\Referral;
use App\ReferralBonus;
use App\ReferralIncrease;
use App\Classes\Helpers;

class InvestController extends Controller {
	public function index() {
		return $this->getView();
	}

	public function invest(Request $request) {
		$request['sum'] = str_replace(',', '.', $request['sum']);
		$messages = [
			'required' => 'Поле не должно быть пустым',
			'balance' => 'На балансе недостаточно средств',
			'minsum' => 'Минимальная сумма вклада на этом тарифе повыше',
			'maxsum' => 'Максимальная сумма вклада на этом тарифе пониже',
			'rate' => 'Такой тариф отсутствует',
			'numeric' => 'Поле должно быть числом',
		];
		$this->validate($request, [
			'sum' => 'required|numeric|balance|rate:'.$request->rate.'|minsum:'.$request->rate.'|maxsum:'.$request->rate,
		], $messages);
		$rec_invest = $this->recInvest($request->sum, $request->rate);
		if ($rec_invest) {
			$this->correctDigits($request->sum);
			$this->setRefBonuses($request->sum);
			return $this->getView('Инвестировано. Ожидайте, когда отработает');
		} else {
			return $this->getView('Что-то пошло не так');
		}
	}

	protected function recInvest($sum, $rate_ident) {
		$rate = Rate::where('ident', $rate_ident)->first();
		$start = Helpers::time();
		$time = $rate->time * 60 * 60;
		$finish = $start + $time;
		$fin_sum = $sum / 100 * $rate->percent;
		$part_sum = $fin_sum / $rate->parts;
		$part_time = $time / $rate->parts;
		$invest = Invest::create([
			'user_ident' => Auth::user()->ident,
			'rate_ident' => $rate_ident,
			'rate_name' => $rate->name,
			'inv_sum' => $sum,
			'fin_sum' => $fin_sum,
			'percent' => $rate->percent,
			'time' => $time,
			'part_time' => $part_time,
			'part_sum' => $part_sum,
			'part' => 0,
			'parts' => $rate->parts,
			'start' => $start,
			'finish' => $finish,
			'status' => 0
		]);
		return $invest;
	}

	protected function setRefBonuses($sum) {
		$referrals = Referral::where('referral', Auth::user()->ident)->get();
		if (count($referrals) <= 0) return true;
		foreach ($referrals as $ref) {
			$this->recRefBonuses($ref->ident, $ref->referral, $ref->percent, $ref->refback, $ref->level, $sum);
		}
	}

	protected function recRefBonuses($ident, $referral, $percent, $refback, $level, $sum) {
		if ($level == 1) {
			$count = 0;
			$referrals = Referral::where('ident', $ident)->where('level', 1)->get();
			foreach ($referrals as $ref) {
				$isset = Invest::where('user_ident', $ref->referral)->first();
				if ($isset !== NULL) $count++;
			}
			$add = ReferralIncrease::where('from', '<=', $count)->orderBy('from', 'desc')->first();
			if ($add !== NULL) {
				$percent = $percent + $add->percent;
			}
		}
		$bns = $sum / 100 * $percent;
		$rb = $bns / 100 * $refback;
		$bonus = $bns - $rb;
		$column = ReferralBonus::where('user_ident', $ident)->where('ref_ident', $referral)->first();
		if ($column === NULL) {
			ReferralBonus::create([
				'user_ident' => $ident,
				'ref_ident' => $referral,
				'bonus' => $bonus,
				'refback' => $rb
			]);
		} else {
			$column->update([
				'bonus' => $column->bonus + $bonus,
				'refback' => $column->refback + $rb
			]);
		}
		$this->correctRefDigits($rb);
		$this->addRefBonus($ident, $bonus, $rb);
	}

	protected function correctDigits($sum) {
		$digits = Digit::where('ident', Auth::user()->ident)->first();
		$digits->update([
			'balance' => $digits->balance - $sum,
			'invested' => $digits->invested + $sum,
			'actively' => $digits->actively + $sum,
		]);
		$statistic = Statistic::first();
		$statistic->update(['invested' => $statistic->invested + $sum]);
		if ($digits and $statistic) return true;
		return false;
	}

	protected function correctRefDigits($refback) {
		$digits = Digit::where('ident', Auth::user()->ident)->first();
		$digits->update([
			'balance' => $digits->balance + $refback,
			'pay_by_refback' => $digits->pay_by_refback + $refback
		]);
	}

	protected function addRefBonus($ident, $bonus, $refback) {
		$digits = Digit::where('ident', $ident)->first();
		$digits->update([
			'balance' => $digits->balance + $bonus,
			'pay_by_refs' => $digits->pay_by_refs + $bonus,
			'spent_on_refback' => $digits->spent_on_refback + $refback
		]);
	}

	protected function getInvestments() {
		$investment = Invest::where('user_ident', Auth::user()->ident)
			->orderBy('start', 'desc')
			->take(25)
            ->get();
        $invest = [];
        foreach ($investment as $inv) {
			if ($inv->status == 0) {
				$status = $inv->finish - Helpers::time();
			} else if ($inv->status == 1) {
				$status = 'Отработано';
			} else {
				$status = 'Неизвестно';
			}
			if ($inv->part < $inv->parts) {
				$latest = ($inv->start + ($inv->part + 1) * $inv->part_time) - Helpers::time();
			} else {
				$latest = 0;
			}
			$invest[] = [
	        	'start' => $inv->start,
	        	'finish' => $inv->finish,
	        	'name' => $inv->rate_name,
				'percent' => $inv->percent,
				'time' => $inv->time,
	        	'invested' => $inv->inv_sum,
	        	'replenished' => $inv->fin_sum,
				'part' => $inv->part,
				'parts' => $inv->parts,
				'sum' => $inv->part_sum * $inv->part,
				'latest' => $latest,
				'status' => $status,
			];
		}
		return $invest;
	}

	protected function getView($success = false) {
		$rates = Rate::all();
		return view('front.cabinet.invest')
			->with('rates', $rates)
			->with('invest', $this->getInvestments())
			->with('success', $success);
	}
}