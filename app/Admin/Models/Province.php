<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/12
 * Time: 16:25
 */
namespace App\Admin\Models ;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Province extends Model{

    protected $table = 'sys_city';

    protected function citys(){
        return $this->hasMany(
            City::class,
            'parentid',
            'id');
    }

    public static function boot(){
        parent::boot();
        static::addGlobalScope(function (Builder $builder){
            $builder->where('parentid','=',0);
        });

    }


    public static function getName($id)
    {
       $ret =  DB::table('sys_city')->select('name')->where('id',$id)->where('parentid',0)->get();
        return $ret[0]->name;
    }

}