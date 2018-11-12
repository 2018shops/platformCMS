<?php
/**
 * Created by PhpStorm.
 * User: langfl
 * Date: 2018/06/19
 * Time: 17:29
 */
//审批 检查
namespace App\Modules\WorkFlow\Service;
use App\Common\Contracts\Service;
use Encore\Admin\Facades\Admin;
use App\Modules\WorkFlow\Repository\CommUserRepo;


class CheckApprov extends Service {

    public function __construct(CommUserRepo $user)
    {
        $this->user = $user;
    }

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    //判断 审批记录状态
    public function judgeApprovRecord($request){
        $record = $request['record'];
        
        if($request['state'] != '2'){
            $ret = [];
            if($record['approv_state'] != config('approv.status.WAIT_APPROV.code')){
                $ret['status'] = false;
                $ret['message'] = '当前记录不可审批';
            }
    
            if($record['approver'] != Admin::user()->id){
                $ret['status'] = false;
                $ret['message'] = '没有审批权限';
            }
            return $ret;
        }
    }
}