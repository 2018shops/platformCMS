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

class ApprovProcess extends Model{


    protected $table = "erp_approv_process";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
//    public function user()
//    {
//        return $this->hasOne(CommUser::class,'id','process_id');
//    }
}