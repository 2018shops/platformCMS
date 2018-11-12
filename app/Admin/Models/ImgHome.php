<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 8:51
 */

namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class ImgHome extends Model
{
    protected $table = "img_home";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}