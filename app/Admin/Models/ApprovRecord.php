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

class ApprovRecord extends Model{


   protected $table = "erp_approv_record";
   protected $primaryKey = 'id';
   protected $keyType = 'string';
   public $timestamps = true;
//    const CREATED_AT = 'created_at';
//    const UPDATED_AT = 'updated_at';

    public static function getModuleName($relation_id){
        return DB::table('erp_approv_record')->select('module_name')->where('relation_id',$relation_id)->first();
    }

   
   public function customer()
   {
       return $this->hasOne(Customer::class,'id','relation_id');
   }
   public function admin()
   {
       return $this->hasOne(AdminUsers::class,'id','approver');
   }
   public function approvsetting()
   {
       return $this->hasOne(ApprovSetting::class,'id','setting_id');
   }
   public function process()
   {
       return $this->hasOne(ApprovProcess::class,'id','process_id');
   }

   public function user()
   {
       return $this->hasOne(CommUser::class,'id','relation_id');
   }
   
   
   
}