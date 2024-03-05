<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('EventManagementTables', function (Blueprint $table) {
            $table->id();
            $table->string('hits');
            $table->string('event_title');
            $table->text('event_description')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('event_type')->nullable();
            $table->string('location_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('event_media')->nullable();
            $table->string('media_type')->nullable();
            $table->boolean('youtube_status')->nullable();
            $table->string('event_cost')->nullable();
            $table->string('notice')->nullable();
            $table->string('active')->nullable();
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
        Schema::dropIfExists('EventManagementTables');
    }
}
