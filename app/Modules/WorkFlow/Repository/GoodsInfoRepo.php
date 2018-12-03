<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:16
 */

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\GoodsInfo;
use App\Common\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

class GoodsInfoRepo extends Repository
{
    public function __construct(GoodsInfo $model)
    {
        $this->model = $model;
    }

    public function update($id, $attributes){
        return $this->model->where('id',$id)->update($attributes);
    }
}