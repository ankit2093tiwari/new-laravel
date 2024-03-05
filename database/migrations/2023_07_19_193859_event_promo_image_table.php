<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventPromoImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('EventPromoImageTables', function (Blueprint $table) {
            $table->id();
            $table->string('hits');
            $table->string('event_title');
            $table->text('event_media')->nullable();
            $table->text('media_type')->nullable();
            $table->boolean('youtube_status')->nullable();
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
        Schema::dropIfExists('EventPromoImageTables');
    }
}
