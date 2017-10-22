<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CabinetController extends Controller {
	public function index() {
		return view('front.cabinet.main');
	}
}