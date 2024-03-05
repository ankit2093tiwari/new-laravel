<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignPageEquityManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('CampaignPageTables', function (Blueprint $table) {
            $table->id();
            $table->string('hits')->nullable();
            $table->text('sec_name')->nullable();
            $table->text('description')->nullable();
            $table->text('media_type')->nullable();
            $table->text('media')->nullable();
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
        Schema::dropIfExists('CampaignPageTables');
    }
}

