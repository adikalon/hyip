<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('statistics', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->decimal('replenished', 10, 2)->unsigned()->default(0);
			$table->decimal('invested', 10, 2)->unsigned()->default(0);
			$table->decimal('balance', 10, 2)->unsigned()->default(0);
			$table->decimal('paidout', 10, 2)->unsigned()->default(0);
			$table->integer('registered')->lenght(7)->unsigned()->nullable()->default(0);
			$table->integer('active')->lenght(7)->unsigned()->nullable()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('statistics');
	}
}