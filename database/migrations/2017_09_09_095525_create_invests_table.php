<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('invests', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('user_ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('rate_ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->string('rate_name', 255)->nullable()->default(NULL);
			$table->decimal('inv_sum', 10, 2)->unsigned()->default(0);
			$table->decimal('fin_sum', 10, 2)->unsigned()->default(0);
			$table->decimal('percent', 5, 2)->unsigned()->default(0);
			$table->integer('time')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('part_time')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->decimal('part_sum', 10, 2)->unsigned()->default(0);
			$table->tinyInteger('part')->lenght(3)->unsigned()->nullable()->default(NULL);
			$table->tinyInteger('parts')->lenght(3)->unsigned()->nullable()->default(NULL);
			$table->integer('start')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('finish')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->tinyInteger('status')->lenght(1)->unsigned()->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('invests');
	}
}