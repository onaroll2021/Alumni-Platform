<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_log', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('timestamp');

            $table->string('email')->nullable();
            $table->string('event')->nullable();
            $table->string('email_type')->nullable();
            $table->string('smtp-id')->nullable();
            $table->string('useragent')->nullable();
            $table->string('IP')->nullable();
            $table->string('sg_event_id')->nullable();
            $table->string('ses_message_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->nullable();
            $table->text('response')->nullable();
            $table->string('attempt')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('asm_group_id')->nullable();
            $table->text('failed_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_log');
    }
}
