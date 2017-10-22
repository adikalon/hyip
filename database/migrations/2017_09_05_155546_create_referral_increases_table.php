<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralIncreasesTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('referral_increases', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->integer('from')->lenght(5)->unsigned()->default(0);
			$table->decimal('percent', 5, 2)->unsigned()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('referral_increases');
	}
}