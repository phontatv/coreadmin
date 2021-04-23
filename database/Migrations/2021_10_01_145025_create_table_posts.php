<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->default('0')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title',255);
            $table->string('thumb',500)->nullable();
            $table->string('slug',255)->unique();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable() ;
            $table->string('status',20)->default('1');
            $table->string('type',20)->default('');
            $table->string('subtype',20)->default('');
            $table->integer('parent')->default('0');
            $table->integer('order')->default('0');
            $table->integer('view')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
