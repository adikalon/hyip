<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('withdraws', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->decimal('sum', 10, 2)->unsigned()->default(0);
			$table->string('wallet', 100)->nullable()->default(NULL);
			$table->string('number', 100)->nullable()->default(NULL);
			$table->text('message');
			$table->integer('date')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('date_accepted')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->tinyInteger('status')->lenght(1)->unsigned()->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('withdraws');
	}
}