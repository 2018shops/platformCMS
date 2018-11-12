<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TranOrder extends Model
{
    public $timestamps = true;
    protected $table = 'tran_order';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public function user()
    {
        return $this->hasOne(CommUserInfo::class,'id','user_id');
    }
}