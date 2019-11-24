<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('recruiter_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->foreign('recruiter_id')->references('id')->on('recruiters')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
