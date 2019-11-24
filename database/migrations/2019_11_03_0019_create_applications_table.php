<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('talent_id');
            $table->unsignedBigInteger('vacant_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->foreign('talent_id')->references('id')->on('talents')->onDelete('cascade'); 
            $table->foreign('vacant_id')->references('id')->on('vacants')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
