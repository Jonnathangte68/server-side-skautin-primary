<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoredSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('talent_id')->nullable();
            $table->unsignedBigInteger('recruiter_id')->nullable();
            $table->string('serach_terms');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('stored_searches', function (Blueprint $table) {
            $table->foreign('talent_id')->references('id')->on('talents')->onDelete('cascade');
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
        Schema::dropIfExists('stored_searches');
    }
}
