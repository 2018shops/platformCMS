<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\ApprovProcess;
use App\Common\Contracts\Repository;

class ApprovProcessRepo extends Repository{
    public function __construct(ApprovProcess $model)
    {
        $this->model = $model;
    }

    //根据模块名称获取步骤
    public function getProcessCount($request){
        return $this->model
            ->select('*')
            ->where('module_name',$request['module'])
            ->count();
    }

    //根据流程ID,获取当前步骤
    public function getProcessSequence($id){
        return optional($this->model
            ->select('sequence')
            ->where('id',$id)
            ->first())
            ->toArray();
    }

    //更具步骤序号,获取经办人ID
    public function getAgentName($sequence){
        return optional($this->model
            ->select('id','agent_name')
            ->where('sequence',$sequence)
            ->first())
            ->toArray();
    }

    //根据模块ID获取,流程第一步
    public function getProcessBySetId($setting_id){
        return optional($this->model
            ->select('*')
            ->where('setting_id',$setting_id)
            ->orderBy('sequence','ASC')
            ->first())
            ->toArray();
    }
}