<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 11:30
 */
namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApprovSetting extends Model{


    protected $table = "erp_approv_setting";
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public static function getId()
    {
        $data = DB::table('erp_approv_setting')
        ->select('id','approv_name')
        ->where('opening_state','01')
        ->get();
        $arr = [];
        foreach($data as $k){
            $arr[$k->id] = $k->approv_name;
        }
        return $arr;
    }
}