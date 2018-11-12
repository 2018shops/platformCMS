<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 12:01
 */

namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class WechatShare extends Model
{
    protected $table = "wechat_share";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}