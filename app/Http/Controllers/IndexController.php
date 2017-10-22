<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Auth;
use Illuminate\Http\Request;
use App\Rate;

class IndexController extends Controller {
	
	public function index() {
		return $this->getView();
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

		return $this->getView();
	}
	
	public function getView() {
		$rates = Rate::all();
		return view('front.main')->with('rates', $rates);
	}
}