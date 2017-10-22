<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class MinSumWithdrawValidateServiceProvder extends ServiceProvider {
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot() {
		Validator::extend('minwith', function ($attribute, $value, $parameters, $validator) {
			if ($value < 100) return false;
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