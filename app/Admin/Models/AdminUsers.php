<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 11:30
 */
namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AdminUsers extends Model{
    protected $table = "admin_users";
    protected $primaryKey = 'id';

    public static function getAdminUser(){
        $data = DB::table('admin_users')
        ->select('id','name')
        ->get();
        $arr = [];
        foreach($data as $k){
            $arr[$k->id] = $k->name;
        }
        return $arr;
    }
}