<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralApplicationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_application_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('publicity_management_type')->nullable();
            $table->tinyInteger('static_add')->nullable();
            $table->boolean('show_static_splash')->nullable();
            $table->boolean('deactivate_adds')->nullable();
            $table->boolean('enable_redirection_to_app_store')->nullable();
            $table->boolean('deactivate_app')->nullable();
            $table->boolean('deactivate_website')->nullable();
            $table->boolean('deactivate_backups')->nullable();
            $table->time('backup_scheduled_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_application_settings');
    }
}
