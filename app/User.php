<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Classes\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable {
	use Notifiable;

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['ident', 'login', 'password', 'email', 'refback', 'date', 'ip', 'role', 'hash'];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password', 'remember_token',
	];

	// Перегружаем метод для переопределения вида письма восстановления пароля
	public function sendPasswordResetNotification($token) {
		$this->notify(new ResetPasswordNotification($token));
	}
}