<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 16:52
 */
namespace App\Modules\WorkFlow\Service;

//工作流审批
use App\Common\Contracts\Service;

class Approval extends Service {
    /**
     * 定义一个afterEvent
     * 如果 审批状态是 4 需要更新对应模块为已审批;
     * 如果 审批状态是 2 需要更新对应模块为已驳回;
     * 
     */
    public $afterEvent = [];

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    /**
     * 审批通过执行操作
     */
    public function handle($request)
    {

    }


}