<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 9:24
 */

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SendEmail extends Model
{

    public $timestamps = true;
    protected $table = "send_email";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}