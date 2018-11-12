<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 16:53
 */
namespace App\Modules\WorkFlow\Service;


//工作流驳回
use App\Common\Contracts\Service;
use App\Modules\WorkFlow\WorkFlow;
use App\Modules\WorkFlow\Repository\ApprovProcessRepo;
use App\Modules\WorkFlow\Repository\ApprovRecordRepo;
use App\Modules\WorkFlow\Repository\ErpCustomerRepo;
use App\Modules\WorkFlow\Repository\ErpApprovSetting;
use App\Modules\WorkFlow\Repository\CommUserRepo;
use Encore\Admin\Facades\Admin;

class Reject extends Service {

    public $record;
    public $process;
    public $customer;
    public $seting;
    public $user;
    public function __construct(ApprovRecordRepo $record,ApprovProcessRepo $process,ErpCustomerRepo $customer,ErpApprovSetting $seting,CommUserRepo $user)
    {
        $this->record = $record;
        $this->process = $process;
        $this->customer = $customer;
        $this->seting = $seting;
        $this->user = $user;
    }

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    /**
     * 审批驳回执行操作
     */
    public function handle($request)
    {
        $request['step'] = 'ok';
        $request['status'] = true;
        $request['message'] = '审批驳回成功';
        
        //审批记录
        $record = $this->record->getApprovRecord($request);
        
        if($record['approv_state'] == config('approv.status.REJECT_APPROV.code')){
            $request['status'] = false;
            $request['message'] = '当前记录已驳回,不可重复驳回';
            return $request;
        }

        if($record['approv_state'] == config('approv.status.END_APPROV.code')){
            $request['status'] = false;
            $request['message'] = '当前记录已通过,不可驳回';
            return $request;
        }

        //更新审批状态 驳回
        $fun = 'update'.$record['module_name'];
        $this->$fun($record['relation_id'],'REJECT_APPROV');

        $data = [
            'approv_state' => config('approv.status.REJECT_APPROV.code'),
            'updated_by'   => Admin::user()->name,
            'updated_at'   => date('Y-m-d H:i:s'),
            'approv_brief' => config('approv.status.REJECT_APPROV.msg')
        ];

        //更新审批记录状态 驳回
        $this->record->updateData($record['id'],$data);
        return $request;
    }

    public function updatecustomer($id,$status){
        $data = [
            'approv_state' => config('approv.status.'.$status.'.code'),
            'updated_by'   => Admin::user()->name,
            'updated_at'   => date('Y-m-d H:i:s')
        ];
        return $this->customer->update($id,$data);
    }

    public function updateuserupgrade($id,$status){
        $data = [
            'approv_state' => config('approv.status.'.$status.'.code'),
        ];
        return $this->user->update($id,$data);
    }
}
