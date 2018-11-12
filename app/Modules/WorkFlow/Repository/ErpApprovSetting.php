<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\ApprovSetting;
use App\Common\Contracts\Repository;

class ErpApprovSetting extends Repository{
    public function __construct(ApprovSetting $model)
    {
        $this->model = $model;
    }

    //根据模块名称获取步骤
    public function getIdByMName($module_name){
        
        return optional($this->model
        ->select('id')
        ->where('module_name',$module_name)
        ->first())
        ->toArray();
    }
}