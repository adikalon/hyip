<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectWalletsTable extends Migration {
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up() {
		Schema::create('project_wallets', function (Blueprint $table) {
			$table->increments('id')->lenght(10)->unsigned();
			$table->string('name', 100)->nullable()->default(NULL);
			$table->string('number', 50)->nullable()->default(NULL);
			$table->string('site', 255)->nullable()->default(NULL);
			$table->string('logo', 255)->nullable()->default(NULL);
			$table->tinyInteger('switch')->lenght(1)->unsigned()->nullable()->default(NULL);
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down() {
		Schema::dropIfExists('project_wallets');
	}
}