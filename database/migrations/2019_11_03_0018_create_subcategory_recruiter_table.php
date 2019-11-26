<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoryRecruiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiter_subcategory', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->unsigned();
            $table->unsignedBigInteger('recruiter_id')->unsigned();

            $table->unique(['subcategory_id', 'recruiter_id']);
            $table->foreign('subcategory_id')->references('id')->on('subcategories')
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
        Schema::dropIfExists('recruiter_subcategory');
    }
}
