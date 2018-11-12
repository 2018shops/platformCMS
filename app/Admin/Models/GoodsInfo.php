<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsInfo extends Model
{
    protected $table = "goods_info";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}
