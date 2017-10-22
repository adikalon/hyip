<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class PasswordValidateServiceProvider extends ServiceProvider {
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot() {
		Validator::extend('pass', function ($attribute, $value, $parameters, $validator) {
			$credentials = [
				'login' => Auth::user()->login,
				'password' => $value,
			];
			
			return Auth::validate($credentials);
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