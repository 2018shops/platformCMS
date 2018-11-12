<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class WxPayOrder extends Model
{
    public $timestamps = true;
    protected $table = 'wx_pay_order';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function user()
    {
        return $this->hasOne(CommUserInfo::class,'id','user_id');
    }
}