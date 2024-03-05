<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HomePageLoopDescMeet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homePageDescMeet', function (Blueprint $table) {
            $table->id();
            $table->string('sectionName')->nullable();
            $table->string('column_1')->nullable();
            $table->string('column_2')->nullable();
            $table->string('description')->nullable();
            $table->string('media')->nullable();
            $table->string('impactYear')->nullable();
            $table->integer('order_in_slider')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamp('last_used_at')->nullable();
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
        Schema::dropIfExists('homePageDescMeet');
    }
}
