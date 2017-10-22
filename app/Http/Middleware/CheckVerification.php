<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\RequestTokenController;
use App\User;

class CheckVerification {
	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/
	public function handle($request, Closure $next) {
		if (Auth::check() and Auth::user()->role == 0) {
			if (isset($request['reverification'])) {
				
				$messages = [
					'required' => 'Поле не должно быть пустым',
					'email' => 'Некоректный фомат',
					'unique' => 'Такой email занят',
				];
				
				Validator::make($request->all(), [
					'email' => [
						'required',
						'email',
						Rule::unique('users')->ignore(Auth::user()->id),
					],
				], $messages)->validate();
				
				$email = $request['email'];

				if ($email != Auth::user()->email) {
					$user = User::where('email', Auth::user()->email)->first();
					$user->update([
						'email' => $email
					]);
				}
				
				$req = new RequestTokenController();
				$req->accountVerification($email);
				
				return response(view('front.cabinet.notverification')
					->with('email', $email)
					->with('success', 'Сообщение отправлено'));
			}
			return response(view('front.cabinet.notverification')->with('email', Auth::user()->email));
		}
		
		return $next($request);
	}
}