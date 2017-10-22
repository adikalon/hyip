<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Rate;

class RateInvestValidateServiceProvider extends ServiceProvider {
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot() {
		Validator::extend('rate', function ($attribute, $value, $parameters, $validator) {
			$rate = Rate::where('ident', $parameters[0])->first();
			if ($rate === NULL) return false;
			return true;
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