<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsLevelsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('referrals_levels', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->tinyInteger('level')->lenght(3)->unsigned()->default(0);
			$table->decimal('percent', 5, 2)->unsigned()->default(0);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('referrals_levels');
	}
}