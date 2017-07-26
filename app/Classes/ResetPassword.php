<?php

namespace App\Classes;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification {
	/**
	* The password reset token.
	*
	* @var string
	*/
	public $token;

	/**
	* Create a notification instance.
	*
	* @param  string  $token
	* @return void
	*/
	public function __construct($token) {
		$this->token = $token;
	}

	/**
	* Get the notification's channels.
	*
	* @param  mixed  $notifiable
	* @return array|string
	*/
	public function via($notifiable) {
		return ['mail'];
	}

	/**
	* Build the mail representation of the notification.
	*
	* @param  mixed  $notifiable
	* @return \Illuminate\Notifications\Messages\MailMessage
	*/
	public function toMail($notifiable) {
		return (new MailMessage)
		->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
		->view('emails.htmlrepassword');
	}
}
