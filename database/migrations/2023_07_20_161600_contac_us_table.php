<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContacUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ContacUsTables', function (Blueprint $table) {
            $table->id();
            $table->text('contact_header')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city_state_zip')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('corp_email')->nullable();
            $table->string('contact_image')->nullable();
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
        //
        Schema::dropIfExists('ContacUsTables');
    }
}

