<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:16
 */

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\Store;
use App\Common\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

class StoreRepo extends Repository
{
    public function __construct(Store $model)
    {
        $this->model = $model;
    }

    //根据ID,获取ID获取店铺信息
    public function getStoreInfo($request){
        return optional($this->model
            ->select('id','name','admin_user')
            ->where('id',$request['id'])
            ->first())
            ->toArray();
    }

    //更具后台登陆账号,获取店铺信息
    public function getStoreInfoByAdminUser($request){
        return optional($this->model
            ->select('id','name','admin_user')
            ->where('admin_user',$request['admin_user'])
            ->first())
            ->toArray();
    }

    public function update($id, $attributes){
        return $this->model->where('id',$id)->update($attributes);
    }
}