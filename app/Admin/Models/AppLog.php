<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    public $timestamps = true;
    protected $table = 'app_log';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}
