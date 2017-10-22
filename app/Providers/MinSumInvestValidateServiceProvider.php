<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Rate;

class MinSumInvestValidateServiceProvider extends ServiceProvider {
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot() {
		Validator::extend('minsum', function ($attribute, $value, $parameters, $validator) {
			$rate = Rate::where('ident', $parameters[0])->first();
			if ($rate !== NULL) {
				if ($value >= $rate->min) return true;
			}
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