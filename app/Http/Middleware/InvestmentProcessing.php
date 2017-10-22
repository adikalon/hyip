<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Invest;
use App\Digit;
use App\Classes\Helpers;

class InvestmentProcessing {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request	 $request
	 * @param  \Closure	 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (Auth::check() and Auth::user()->role != 0) {
			$time = Helpers::time();
			$invests = Invest::where('user_ident', Auth::user()->ident)->where('status', 0)->get();
			foreach ($invests as $invest) {
				if ($time >= $invest->finish) {
					$this->finishTime($invest);
				} else {
					$this->currentTime($invest, $time);
				}
			}
		}
		return $next($request);
	}
	
	protected function finishTime($invest) {
		$parts = $invest->parts - $invest->part;
		$sum = $invest->part_sum * $parts;
		$invest->update([
			'part' => $invest->parts,
			'status' => 1
		]);
		$digits = Digit::where('ident', Auth::user()->ident)->first();
		$digits->update([
			'balance' => $digits->balance + $sum,
			'actively' => $digits->actively - $invest->inv_sum,
		]);
		$this->correctActively($digits);
	}
	
	protected function currentTime($invest, $time) {
		$passedTime = $time - $invest->start;
		$passedParts = floor($passedTime / $invest->part_time) - $invest->part;
		if ($passedParts > 0) {
			$passedSum = $passedParts * $invest->part_sum;
			$invest->update([
				'part' => $invest->part + $passedParts
			]);
			$digits = Digit::where('ident', Auth::user()->ident)->first();
			$digits->update([
				'balance' => $digits->balance + $passedSum
			]);
		}
	}
	
	protected function correctActively($digit) {
		if ($digit->actively < 0) {
			$digits->update([
				'actively' => 0,
			]);
		}
	}
}