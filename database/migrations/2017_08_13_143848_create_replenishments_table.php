<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplenishmentsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('replenishments', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->string('wallet', 100)->nullable()->default(NULL);
			$table->string('number', 100)->nullable()->default(NULL);
			$table->string('transaction', 255)->nullable()->default(NULL);
			$table->decimal('sum', 10, 2)->unsigned()->default(0);
			$table->tinyInteger('status')->lenght(1)->unsigned()->nullable()->default(NULL);
			$table->integer('date')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('date_accepted')->lenght(10)->unsigned()->nullable()->default(NULL);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('replenishments');
	}
}