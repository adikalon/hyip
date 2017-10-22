<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('rates', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->string('name', 255)->nullable()->default(NULL);
			$table->decimal('min', 10, 2)->unsigned()->default(0);
			$table->decimal('max', 10, 2)->unsigned()->default(0);
			$table->decimal('percent', 5, 2)->unsigned()->default(0);
			$table->unsignedSmallInteger('time')->lenght(3)->default(0);
			$table->tinyInteger('parts')->lenght(2)->unsigned()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('rates');
	}
}