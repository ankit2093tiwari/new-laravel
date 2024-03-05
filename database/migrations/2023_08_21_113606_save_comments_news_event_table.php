<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaveCommentsNewsEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('save_comments_news_event_table', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->enum('sectionName', ['news', 'event']);
            $table->string('name')->nullable();
            $table->string('comment')->nullable();
            $table->string('email_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('save_comments_news_event_table');
    }
}
