<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/4/2
 * Time: 15:09
 */
namespace App\Admin\Models ;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model {

    protected $table = 'erp_customer';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function setCustomerNoAttribute($value)
    {
        $this->attributes['customer_no'] =
            $this->attributes['customer_no'] ?? SNO($this->table);

    }

    public function getCustomerNoAttribute($value)
    {
        return "CSN-".$this->attributes['customer_no'];

    }

    public static function getCustomerName($id){
        return DB::table('erp_customer')->select('name')->where('id',$id)->first();
    }

    public function sysuser()
    {
        return $this->hasOne(
            Administrator::class,
            'id',
            'created_by'
            );
    }

    public function leads()
    {
        return $this->hasMany(
            Leads::class ,
            'customer_id',
            'id'
            );
    }
    

}