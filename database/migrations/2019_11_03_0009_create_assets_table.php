<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('isvideo');
            $table->boolean('isimage');
            $table->string('file_extension');
            $table->integer('length');
            $table->string('file_uri');
            $table->string('path');
            $table->unsignedBigInteger('talent_playlist_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('talent_playlist_id')->references('id')->on('talent_playlist')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
