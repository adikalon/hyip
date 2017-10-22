<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Digit;

class BalanceInvestValidateServiceProvider extends ServiceProvider {
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot() {
		Validator::extend('balance', function ($attribute, $value, $parameters, $validator) {
			$balance = Digit::where('ident', Auth::user()->ident)->first();
			if ($value <= $balance->balance) return true;
			return false;
		});
	}

	/**
	* Register the application services.
	*
	* @return void
	*/
	public function register() {
		//
	}
}