<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTermMeta extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('term_meta', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('term_id')->unsigned();
			$table->foreign('term_id')->references('id')->on('terms');
			$table->string('key', 191);
			$table->string('value', 255)->default('');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('term_meta');
	}
}
