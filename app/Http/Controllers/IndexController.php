<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Auth;
use Illuminate\Http\Request;

class IndexController extends Controller {
	
	public function index() {
		return view('front.main');
	}
	
	// Запоминаем реферера в сессию
	public function referer($ref) {
		if (Auth::guest()) {
			$user = DB::table('users')->select('ident', 'login', 'refback')->where('ident', $ref)->first();
			if (count($user)) {
				$referer = [
					'ident' => $user->ident,
					'login' => $user->login,
					'refback' => $user->refback,
				];
				Session::put('referer', $referer);
			}
		}
		//dump(Session::get('referer'));
		return view('front.main');
	}
}