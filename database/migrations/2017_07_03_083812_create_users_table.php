<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->string('login', 255)->unique()->nullable()->default(NULL);
			$table->string('password', 255)->nullable()->default(NULL);
			$table->string('email', 255)->unique()->nullable()->default(NULL);
			$table->decimal('refback', 5, 2)->unsigned()->default(0);
			$table->integer('date')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->string('ip', 15)->nullable()->default(NULL);
			$table->tinyInteger('role')->lenght(1)->unsigned()->nullable()->default(NULL);
			$table->string('hash', 255)->nullable()->default(NULL);
			$table->rememberToken();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('users');
	}
}