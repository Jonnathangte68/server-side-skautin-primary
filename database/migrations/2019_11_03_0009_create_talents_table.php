<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('birth_year');
            $table->string('gender');
            $table->unsignedBigInteger('profile_picture')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('address_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('talents', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('profile_picture')->references('id')->on('assets')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        // Crossed-references for talent playlist 
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('assets');
        Schema::drop('talent_playlists');
        Schema::dropIfExists('talents');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
