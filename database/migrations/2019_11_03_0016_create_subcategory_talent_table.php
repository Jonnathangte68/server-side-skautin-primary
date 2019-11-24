<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoryTalentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategory_talent', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->unsigned();
            $table->unsignedBigInteger('talent_id')->unsigned();

            $table->unique(['subcategory_id', 'talent_id']);
            $table->foreign('subcategory_id')->references('id')->on('subcategories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('talent_id')->references('id')->on('talents')
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
        Schema::dropIfExists('subcategory_talent');
    }
}
