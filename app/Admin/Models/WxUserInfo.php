<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/30
 * Time: 14:10
 */

namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class WxUserInfo extends Model
{
    protected $table = "wx_user_info";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}