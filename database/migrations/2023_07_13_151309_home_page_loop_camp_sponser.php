<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HomePageLoopCampSponser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homePageCampSpons', function (Blueprint $table) {
            $table->id();
            $table->string('view')->nullable();
            $table->string('sectionName')->nullable();
            $table->string('title')->nullable();
            $table->text('news_artical')->nullable();
            $table->text('media')->nullable();
            $table->text('media_type')->nullable();
            $table->boolean('youtube_status')->nullable();
            $table->date('expire_date')->nullable();
            $table->date('featuredItem')->nullable();
            $table->enum('active', ['0', '1']);
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
        Schema::dropIfExists('homePageCampSpons');
    }
}
