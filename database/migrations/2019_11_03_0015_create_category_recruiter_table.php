<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryRecruiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_recruiter', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->unsignedBigInteger('recruiter_id')->unsigned();

            $table->unique(['category_id', 'recruiter_id']);
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('recruiter_id')->references('id')->on('recruiters')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_recruiter');
    }
}
