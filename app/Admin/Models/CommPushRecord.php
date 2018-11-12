<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 11:30
 */
namespace App\Admin\Models;


use Encore\Admin\Auth\Database\Administrator;

use Illuminate\Database\Eloquent\Model;

class CommPushRecord extends Model{
    protected $table = "comm_push_record";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}

