<?php

namespace App\Http\Middleware;

use Closure;
use App\Statistic;
use App\Digit;
use Illuminate\Support\Facades\View;
use Auth;
use Schema;

class GetData {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request	 $request
	 * @param  \Closure	 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$this->getStatistics();
		$this->getDigits();
		return $next($request);
	}

	protected function getStatistics() {
		if (Schema::hasTable('statistics')) {
			$statistic = Statistic::all();
			if (count($statistic) > 0) {
				$statistic = $statistic->first();
				View::share('stat', $statistic);
			}
		}
	}
	
	protected function getDigits() {
		if (Auth::check()) {
			if (Schema::hasTable('digits')) {
				$digits = Digit::all()->where('ident', Auth::user()->ident);
				if (count($digits) > 0) {
					$digits = $digits->first();
					View::share('digits', $digits);
				}
			}
		}
	}
}