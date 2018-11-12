<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 17:17
 */

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\CashOrder;
use App\Common\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

class CashOrderRepo extends Repository
{
    public function __construct(CashOrder $model)
    {
        $this->model = $model;
    }

    public function update($id, $attributes)
    {
        return $this->model->where('relation_id',$id)->update($attributes);
    }
}