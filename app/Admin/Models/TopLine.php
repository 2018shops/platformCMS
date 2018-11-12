<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/17
 * Time: 9:15
 */

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TopLine extends Model{

    protected  $table = 'erp_top_line';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}