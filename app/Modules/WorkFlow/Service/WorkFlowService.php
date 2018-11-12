<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 16:57
 */
namespace App\Modules\WorkFlow\Service;

use App\Common\Contracts\Service;
use Illuminate\Support\Facades\Log;

class WorkFlowService extends Service {

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }
    
    /**
     * 获取审批历史
     */
    public function  getApproveHistory($request){

    }

    /**
     * 检查是否有删除权限
     */
    public function  checkApproveDestroy($request){
        Log::debug("checkApproveDestroy");
        Log::debug(json_encode($request));
    }

    /**
     * 检查是否有编辑权限
     */
    public function  checkApproveEdit($request){
       Log::debug("checkApproveEdit");
       Log::debug(json_encode($request));
    }
}