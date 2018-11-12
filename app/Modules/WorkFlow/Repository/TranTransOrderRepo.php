<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 17:22
 */

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\TranTransOrder;
use App\Common\Contracts\Repository;

class TranTransOrderRepo extends Repository
{
    public function __construct(TranTransOrder $model)
    {
        $this->model = $model;
    }

    public function getOrderInfo($request){
        return optional($this->model
            ->select('id','business_code','trans_amt','user_id','status')
            ->where('id',$request['id'])
            ->first()
        )->toArray();
    }

    public function getOrderInfoByUserId($param){
        return optional($this->model
            ->select('id','business_code','trans_amt','user_id','status')
            ->where($param)
            ->first()
        )->toArray();
    }

    public function update($id, $attributes)
    {
        return $this->model->where('id',$id)->update($attributes);
    }
}