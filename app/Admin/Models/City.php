<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/12
 * Time: 16:25
 */
namespace App\Admin\Models ;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class City extends Model{

    protected $table = 'sys_city';

    public function province()
    {
        
    }


}