<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 15:15
 */
namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class AcctBookingTemplet extends Model{


    protected $table = "acct_booking_templet";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}