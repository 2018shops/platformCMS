<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:12
 */

namespace App\Modules\WorkFlow\Service;


use App\Common\Contracts\Service;
use App\Modules\WorkFlow\Repository\GoodsInfoRepo;

class GoodsExamineService extends Service
{
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function goodsExaminePass(GoodsInfoRepo $repo,$request){
        $params = [
            'status' => 10,
            'describe' => ''
        ];
        $repo->update($request['id'],$params);
        return [
            'code'    => '0000',
            'message' => '提交成功!'
        ];
    }
     /**
      * @desc 圣品审核拒绝
      */
    public function goodsExamineRefuse(GoodsInfoRepo $repo,$request){
        $params = [
            'status' => 35,
            'describe' => $request['text']
        ];
        $repo->update($request['id'],$params);
        return [
            'code'    => '0000',
            'message' => '提交成功!'
        ];
    }
}