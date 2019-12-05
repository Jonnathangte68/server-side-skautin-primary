<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecruitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('profile_picture')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('recruiters', function (Blueprint $table) {
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
        Schema::dropIfExists('recruiters');
    }
}
