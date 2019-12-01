<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetFavoriteFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_favorite_folder', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id')->unsigned();
            $table->unsignedBigInteger('favorite_folder_id')->unsigned();

            $table->unique(['asset_id', 'favorite_folder_id']);
            $table->foreign('asset_id')->references('id')->on('assets')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('favorite_folder_id')->references('id')->on('favorite_folders')
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
        Schema::dropIfExists('asset_favorite_folder');
    }
}
