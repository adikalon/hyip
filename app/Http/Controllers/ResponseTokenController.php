<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ResponseTokenController extends Controller {
	
	public function accountVerification($token) {
		$user = User::where('hash', $token)->first();
		if (!$user) return view('front.cabinet.verificationerror');
		$user->hash = NULL;
		$user->role = 1;
		$user->save();
		return redirect('cabinet')->with('verification', 'Аккаунт подтвержден');
	}

}