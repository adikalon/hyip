<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('digits', function (Blueprint $table) {
				$table->increments('id')->lenght(10)->unsigned();
				$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
				$table->decimal('balance', 10, 2)->unsigned()->default(0);
				$table->decimal('replenished', 10, 2)->unsigned()->default(0);
				$table->decimal('invested', 10, 2)->unsigned()->default(0);
				$table->decimal('pay_by_inv', 10, 2)->unsigned()->default(0);
				$table->decimal('payment', 10, 2)->unsigned()->default(0);
				$table->decimal('widthdraw', 10, 2)->unsigned()->default(0);
				$table->decimal('actively', 10, 2)->unsigned()->default(0);
				$table->decimal('pending', 10, 2)->unsigned()->default(0);
				$table->decimal('pay_by_refs', 10, 2)->unsigned()->default(0);
				$table->decimal('pay_by_refback', 10, 2)->unsigned()->default(0);
				$table->decimal('spent_on_refback', 10, 2)->unsigned()->default(0);
			});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('digits');
	}
}