<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralApplicationSettings extends Model
{
    protected $fillable = ['publicity_management_type', 'show_static_splash', 'deactivate_adds', 'enable_redirection_to_app_store', 'deactivate_app', 'deactivate_website', 'deactivate_backups', 'backup_scheduled_time'];
}
