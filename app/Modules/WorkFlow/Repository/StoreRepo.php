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

    public function getStoreInfo($request){
        return optional($this->model
            ->select('id','name','tel')
            ->where('id',$request['id'])
            ->first())
            ->toArray();
    }

    public function update($id, $attributes){
        return $this->model->where('id',$id)->update($attributes);
    }
}