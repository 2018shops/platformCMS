<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/25
 * Time: 11:25
 */

namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class GoodsOrder extends Model
{
    protected $table = "goods_order";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function goods()
    {
        return $this->hasOne(GoodsInfo::class,'id','goods_id');
    }

    public function user()
    {
        return $this->hasOne(WxUserInfo::class,'user_id','user_id');
    }

    public function goodspay(){
        return $this->hasOne(GoodsPayOrder::class,'order_id','id');
    }
}