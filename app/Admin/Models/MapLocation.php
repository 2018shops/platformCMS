<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class MapLocation extends Model
{
    public $timestamps = true;
    protected $table = 'map_location';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public function user()
    {
        return $this->hasOne(CommUserInfo::class,'id','user_id');
    }
}
