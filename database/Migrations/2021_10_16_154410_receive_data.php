<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReceiveData extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('receive_data', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->string('phone', 255)->nullable();
			$table->string('add', 255)->nullable();
			$table->string('title', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->longText('note')->nullable();
			$table->longText('content')->nullable();
			$table->integer('status')->default(0);
			$table->string('type', 20)->default('');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('receive_data');
	}
}
