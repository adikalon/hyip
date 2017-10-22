<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('wallets', function (Blueprint $table) {
				$table->increments('id')->lenght(10)->unsigned();
				$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
				$table->string('qiwi', 20)->nullable()->default(NULL);
				$table->string('payeer', 20)->nullable()->default(NULL);
			});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('wallets');
	}
}