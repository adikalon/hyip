<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run() {
		DB::table('users')->insert([
			'ident' => 123,
			'login' => 'admin',
			'pass' => '123',
			'mail' => 'admin@mail.ru',
			'refback' => 50,
			'balance' => 0,
			'date' => time(),
			'ip' => '127.0.0.1',
			'role' => 0,
			'auth' => 'qwerty',
			'hash' => 'qwerty'
		]);
	}
}