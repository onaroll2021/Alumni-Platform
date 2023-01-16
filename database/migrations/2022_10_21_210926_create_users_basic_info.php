<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersBasicInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_basic_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('avatar_filename')->nullable();
            $table->string('name_prefix')->nullable();
            $table->string('name_first')->nullable();
            $table->string('name_last')->nullable();
            $table->string('location')->nullable();
            $table->integer('TFHA_alumni_year')->nullable();
            $table->string('university_name')->nullable();
            $table->string('diploma')->nullable();
            $table->longText('short_bio')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('indigenous_identity')->nullable();
            $table->string('visible_minority')->nullable();
            $table->string('languages')->nullable();
            $table->string('TFHA_years_in_program')->nullable();
            $table->string('total_scholarship_funds')->nullable();

            $table->string('primary_address_address')->nullable();
            $table->string('primary_address_address_2')->nullable();
            $table->string('primary_address_city')->nullable();
            $table->string('primary_address_province')->nullable();
            $table->string('primary_address_postal')->nullable();
            $table->string('primary_address_country')->nullable();
            
            $table->string('shipping_address_address')->nullable();
            $table->string('shipping_address_address_2')->nullable();
            $table->string('shipping_address_city')->nullable();
            $table->string('shipping_address_province')->nullable();
            $table->string('shipping_address_postal')->nullable();
            $table->string('shipping_address_country')->nullable();

            $table->string('primary_phone_area')->nullable();
            $table->string('primary_phone_number')->nullable();
            $table->string('mobile_phone_area')->nullable();
            $table->string('mobile_phone_number')->nullable();
            $table->string('work_phone_area')->nullable();
            $table->string('work_phone_number')->nullable();
            $table->string('other_phone_area')->nullable();
            $table->string('other_phone_number')->nullable();

            $table->string('primary_email')->nullable(); 
            $table->string('alternative_email')->nullable(); 
            $table->string('work_email')->nullable(); 

            $table->string('contact_instagram')->nullable();
            $table->string('contact_facebook')->nullable();
            $table->string('contact_twitter')->nullable(); 
            $table->string('contact_linkedin')->nullable(); 

            $table->string('personal_website')->nullable(); 
            $table->string('link_of_interest_1')->nullable(); 
            $table->string('link_of_interest_2')->nullable();
            $table->string('link_of_interest_3')->nullable();
            
            $table->string('pronouns')->nullable();
            $table->dateTime('lastsaved_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_basic_info');
    }
}
