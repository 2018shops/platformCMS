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

class CommUser extends Model{


    protected $table = "comm_user_info";
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public function balance()
    {
       return  $this->belongsTo(AcctFinance::class,'id','user_id');
    }

    public static function getUserName($id){
        return DB::table('comm_user_info')->select('user_name')->where('id',$id)->first();
    }

    public function wx()
    {
        return $this->hasOne(WxUserInfo::class,'user_id','user_id');
    }

    public function setUserNameAttribute($value){
        $str = $value;
        if(!is_string($str))return $str;
        if(!$str || $str == 'undefined')return '';

        $text = json_encode($str); //暴露出unicode
        $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
            return addslashes($str[0]);
        },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
        return json_decode($text);

    }

    //微信 特殊昵称处理 emoji 处理
    public function getUserNameAttribute($value){
        $text = json_encode($value); //暴露出unicode
        $text = preg_replace_callback('/\\\\\\\\/i',function($str){
            return '\\';
        },$text); //将两条斜杠变成一条，其他不动
        return json_decode($text);
    }
}