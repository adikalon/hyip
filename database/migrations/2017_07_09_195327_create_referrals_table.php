<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('referrals', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('referral')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->tinyInteger('level')->lenght(1)->unsigned()->nullable()->default(NULL);
			$table->decimal('percent', 5, 2)->unsigned()->default(0);
			$table->decimal('refback', 5, 2)->unsigned()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('referrals');
	}
}