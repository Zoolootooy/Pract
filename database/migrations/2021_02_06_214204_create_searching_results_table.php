<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searching_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('search_id');
            $table->foreign('search_id')->references('id')->on('searches');
            $table->string('title');
            $table->string('link');
            $table->string('preview');
            $table->string('channel');
            $table->string('channelLink');
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
        Schema::dropIfExists('searching_results');
    }
}
