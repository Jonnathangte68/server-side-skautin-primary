<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->unsignedBigInteger('follower_id')->nullable();
            $table->unsignedBigInteger('following_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('connections', function (Blueprint $table) {
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connections');
    }
}
