<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('DonationTypeTables', function (Blueprint $table) {
            $table->id();
            $table->text('zelle_text')->nullable();
            $table->string('zelle_image')->nullable();
            $table->string('cash_app_text')->nullable();
            $table->string('cash_app_image')->nullable();
            $table->string('mailing_text')->nullable();
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
        Schema::dropIfExists('DonationTypeTables');
    }
}

