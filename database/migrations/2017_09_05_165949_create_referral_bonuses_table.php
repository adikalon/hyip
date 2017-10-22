<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralBonusesTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('referral_bonuses', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('user_ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->integer('ref_ident')->lenght(10)->unsigned()->nullable()->default(NULL);
			$table->decimal('bonus', 10, 2)->unsigned()->default(0);
			$table->decimal('refback', 10, 2)->unsigned()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('referral_bonuses');
	}
}