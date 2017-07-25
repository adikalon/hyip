<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAccess {
	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/
	public function handle($request, Closure $next) {

		if (!Auth::check() or (Auth::check() and Auth::user()->role != 2)) {
			abort('404');
		}

		return $next($request);
	}
}