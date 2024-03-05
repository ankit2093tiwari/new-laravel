<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HomePageData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homePages', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->string('header_text');
            $table->string('mission_text');
            $table->text('page_text')->nullable();
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('impact_link')->nullable();
            $table->string('section_title')->nullable();
            $table->string('section_post')->nullable();
            $table->string('section_media')->nullable();
            $table->string('issue_link')->nullable();
            $table->string('job_post_link')->nullable();
            $table->string('promo_video')->nullable();
            $table->string('youtube_status')->nullable();
            $table->string('youtube_status')->nullable();
            $table->boolean('youtube_status_promo')->nullable();
            $table->boolean('youtube_status_middle')->nullable();
            $table->string('media_type_middle')->nullable();
            $table->string('media_type_promo')->nullable();
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
        Schema::dropIfExists('homePage');
    }
}
