<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_connections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requestor_id')->nullable();
            $table->unsignedBigInteger('requested_id')->nullable();
            $table->boolean('confirmed');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('pending_connections', function (Blueprint $table) {
            $table->foreign('requestor_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('requested_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_connections');
    }
}
