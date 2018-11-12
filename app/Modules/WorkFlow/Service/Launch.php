<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 16:48
 */


namespace App\Modules\WorkFlow\Service;

//工作流发起
use App\Common\Contracts\Service;
use App\Modules\WorkFlow\WorkFlow;
use App\Modules\WorkFlow\Repository\ApprovProcessRepo;
use App\Modules\WorkFlow\Repository\ApprovRecordRepo;
use App\Modules\WorkFlow\Repository\ErpCustomerRepo;
use App\Modules\WorkFlow\Repository\ErpApprovSetting;
use App\Modules\WorkFlow\Repository\CommUserRepo;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Launch extends Service {

    use TraitMethod ;
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


    public function handle($request)
    {
        $request['step'] = 'ok';
        $request['status'] = true;
        $request['message'] = '审批成功,继续下一步';
        
        //审批记录
        $record = $this->record->getApprovRecord($request);
        
        //审批记录为空, 此操作 提交审批
        if(empty($record) || $record['approv_state'] == '2'){
            //提交审批,添加提交审批记录,添加下一步审批记录,状态为待审批
            $flag = $this->subApprov($request);
            if($flag)
                $request['message'] = '提交审批成功';
            else
                $request['message'] = '提交审批失败';
            
            return $request;
        }

        //判断 审批记录状态
        $status = WorkFlow::service('CheckApprov')
                ->with('record',$record)
                ->with('state',$request['state'])
                ->run('judgeApprovRecord');
        if($status){
            return $status;
        }

        //审批总步骤
        $count = $this->process->getProcessCount($request);

        //获取审批当前步骤 是第几记步
        $sequence = $this->process->getProcessSequence($record['process_id']);
        
        //判断审批是不是最后一步
        if($sequence['sequence'] == $count){
            
            //更新用户表审批状态
            // $fun = 'update'.$record['module_name'];
            // $ret = $this->$fun($record['relation_id'],'END_APPROV');

            $ret = $this->fun($record['module_name'],$record['relation_id'],'END_APPROV');

            //有返回数据,先修改 审批详情 状态,再更改 生僻通过状态
            if($ret){
                return $ret;
            }

            //更新审批记录
            $this->updateRecord($record['id'],'END_APPROV');
            $request['message'] = '审批成功';
            return $request;
        }

        //事物
        DB::beginTransaction();
        try{
            //更新当前审批记录状态
            $this->updateRecord($record['id'],'PASS_APPROV');
            //添加下一步审批记录
            $flag = $this->addRecord($record,$sequence['sequence']);
        }catch(\Exception $ex){
            DB::rollback();
        }
        
        DB::commit();

        if($flag){
            return $request;
        }else{
            $request['status'] = false;
            $request['message'] = '审批失败';
            return $request;
        }
    }

    //更新当前审批记录状态
    public function updateRecord($id,$status){

        $data = [
            'approv_state' => config('approv.status.'.$status.'.code'),
            'approv_brief' => config('approv.status.'.$status.'.msg'),
            'updated_by'   => Admin::user()->name,
            'updated_at'   => date('Y-m-d H:i:s')
        ];
        
        //更新审批记录 状态
        return $this->record->updateData($id,$data);        
    }

    //添加下一步审批记录
    public function addRecord($record,$sequence){

        //下一步序号
        $sequence = $sequence + 1;
        //根据审批序号,查询下一步审批人员
        $processInfo = $this->process->getAgentName($sequence);

        $data = [
            'id' => ID(),
            'module_name'  => $record['module_name'],
            'relation_id'  => $record['relation_id'],
            'setting_id'   => $record['setting_id'],
            'process_id'   => $processInfo['id'],
            'approver'     => $processInfo['agent_name'],
            'approv_state' => config('approv.status.WAIT_APPROV.code'),
            'approv_brief' => $record['approv_brief']
        ];

        return $this->record->insert($data);
    }

    //提交审批
    public function subApprov($request){
        
        //获取模版设置id
        $setInfo = $this->getIdByMName($request['module']);
        $fun = 'update'.$request['module'].'State';

        $data = [
            'id' => ID(),
            'module_name'  => $request['module'],
            'relation_id'  => $request['id'],
            'setting_id'   => $setInfo['id'],
            'process_id'   => config('approv.status.SUB_APPROV.msg'),
            //经办人 ID
            'approver'     => Admin::user()->id,
            //状态
            'approv_state' => config('approv.status.SUB_APPROV.code'),
            'approv_brief' => config('approv.status.SUB_APPROV.msg'),
            'created_by'   => Admin::user()->name,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_by'   => Admin::user()->name,
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        DB::beginTransaction();
        try{
            //添加审批提交记录
            $this->record->insert($data);

            //获取当前设置模块,第一步
            $processInfo = $this->getProcessBySetId($setInfo['id']);
            
            $data['id'] = ID();
            $data['approver'] = $processInfo['agent_name'];
            $data['process_id'] = $processInfo['id'];
            $data['approv_state'] = config('approv.status.WAIT_APPROV.code');
            $data['approv_brief'] = config('approv.status.WAIT_APPROV.msg');

            //更新提交审批 数据
            $this->fun($request['module'],$request['id'],'SUB_APPROV');

            //添加 下一步 待审批记录
            $ret = $this->record->insert($data);
        }catch (\Exception $ex){
            DB::rollback();
        }
        DB::commit();

        return $ret;
    }

    public function fun($module,$id,$state){
        switch($module){
            case 'userupgrade' :
                return WorkFlow::service('UserUpgradeService')
                    ->with('id',$id)
                    ->with('state',$state)
                    ->run('userUpgrade');
        }
    }

    //获取模版设置id
    public function getIdByMName($module){
        $setInfo = $this->seting->getIdByMName($module);
        if(!$setInfo){
            $request['status'] = false;
            $request['message'] = '审批模板未设置';
            return $request;
        }
        return $setInfo;
    }

    //获取当前设置模块,第一步
    public function getProcessBySetId($id){
        $setInfo = $this->process->getProcessBySetId($id);
        if(!$setInfo){
            $request['status'] = false;
            $request['message'] = '审批流程未设置';
            return $request;
        }
        return $setInfo;
    }
}