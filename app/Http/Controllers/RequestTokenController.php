<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Mail;
use Auth;

class RequestTokenController extends Controller {

	public function accountVerification($email) {
		$token = Str::random(100);
		$user = User::where('email', $email)->first();
		if (!$user) return false;
		$user->hash = $token;
		$user->save();
		Mail::send('emails.accountverification', ['token' => route('account.verification', $token)], function($m) use ($email) {
			$m->from('post@mail.ru', 'Наш Хайп');
			$m->to($email, 'Братку')->subject('Подтверждение акканта');
		});
		return true;
	}

}