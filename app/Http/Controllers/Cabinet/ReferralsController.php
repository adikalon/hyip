<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Digit;
use App\User;
use App\Referral;
use Auth;

class ReferralsController extends Controller {
	
	public function index() {
		return view('front.cabinet.referrals')
			->with('ref', $this->getReferrals(Auth::user()->ident));
	}
	
	protected function getReferrals($ident) {
		$ref = [];
		$referrals = Referral::all()->where('ident', $ident);
		foreach ($referrals as $r) {
			$ref[] = [
				'login' => $this->getUser($r['referral'])->login,
				'ident' => $r['referral'],
				'referer' => $this->getFirstReferer($r['referral']),
				'date' => $this->getUser($r['referral'])->date,
				'level' => $r['level'],
				'percent' => $r['percent'],
				'refback' => $r['refback'],
			];
		}
		return $ref;
	}
	
	protected function getUser($ident) {
		$user = User::all()->where('ident', $ident)->first();
		return $user;
	}
	
	protected function getFirstReferer($ident) {
		$referral = Referral::all()->where('referral', $ident)->where('level', 1)->first();
		$user = User::all()->where('ident', $referral->ident)->first();
		return $user->login;
	}
	
	public function getReferralInfo($ident) {
		if (!$this->ifIssetReferral($ident)) abort(404);
		$ref = $this->getUser($ident);
		return view('front.cabinet.referral')->with('login', $ref->login);
	}
	
	protected function ifIssetReferral($ident) {
		$id = Auth::user()->ident;
		$referral = Referral::all()
			->where('ident', $id)
			->where('referral', $ident);
		if (count($referral) > 0) return true;
		return false;
	}
}