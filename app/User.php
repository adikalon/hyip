<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable {
	use Notifiable;

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['ident', 'login', 'password', 'email', 'refback', 'balance', 'date', 'ip', 'role', 'hash'];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token) {
		$this->notify(new ResetPasswordNotification($token));
	}
}