<?php

namespace App\Classes;

use App\User;
use App\ProjectWallet;

class Helpers {
	
	static public function getUserLoginOnIdent($ident) {
		return User::where('ident', $ident)->first()->login;
	}
	
	static public function time() {
		return time();
	}
	
}