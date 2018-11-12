<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\ApprovRecord;
use App\Common\Contracts\Repository;

class ApprovRecordRepo extends Repository{
    public function __construct(ApprovRecord $model)
    {
        $this->model = $model;
    }

    public function getApprovRecord($request){
        return optional($this->model
            ->select('*')
            ->where('relation_id',$request['id'])
            ->where('module_name',$request['module'])
            ->orderBy('id','desc')
            ->first())
            ->toArray();
    }

    public function updateData($id, $attributes)
    {
        return $this->model->where('id',$id)->update($attributes);
    }
}