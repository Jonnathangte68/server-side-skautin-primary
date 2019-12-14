<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('link', 100);
            $table->tinyInteger('type');
            $table->bigInteger('asset_id')->unsigned();
            $table->integer('clicks')->default(0);
            $table->tinyInteger('perc')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
