<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->boolean('verified')->default(false);
            $table->boolean('active')->default(false);
            $table->string('verified_token')->nullable();
            $table->string('avatar_filename')->nullable()->default(null);
            $table->enum('type', ['ALUMNI', 'ADMIN'])->default('ALUMNI');
            $table->string('password', 60);
            $table->string('registerIP', 32);
            $table->string('lastIP', 32)->nullable()->default(null);
            $table->dateTime('lastActivity');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('marketing')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
