<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsInfo extends Model
{
    protected $table = "goods_info";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function store(){
        return $this->hasOne(Store::class,'id','store_id');
    }

    public static function getStoreName($goods_id){
        $ret = DB::table('goods_info as t0')
        ->select('t1.name')
        ->leftJoin('store as t1',function($join){
            $join->on('t0.store_id','t1.id');
        })
        ->where('t0.id',$goods_id)
        ->first();
        if(!$ret) return '自营';
        return $ret->name;
    }
}
