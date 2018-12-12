<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsClassify extends Model
{
    protected $table = "goods_classify";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public static function getGoodsClassifyList($id){
        $seleceOption = [];
        if($id){
            $options = DB::table('goods_classify')->select('id','name')->find($id);
            $seleceOption[$options->id] = $options->name;;
        }else{
            $options = DB::table('goods_classify')->select('id','name as text')->get();
        
            foreach($options as $option){
                $seleceOption[$option->id] = $option->text;
            }
        }
        return $seleceOption;
    }
}