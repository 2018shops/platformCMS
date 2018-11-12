<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ShareControl extends Model
{
    public $timestamps = true;
    protected $table = 'share_control';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}
