<?php
/**
 * Created by PhpStorm.
 * User: langfl
 * Date: 2018/06/21
 * Time: 14:10
 * 用户升级
 */

namespace App\Modules\WorkFlow\Service;
use App\Common\Contracts\Service;
use App\Modules\WorkFlow\Repository\CashOrderRepo;
use App\Modules\WorkFlow\Repository\InviteCodeRepo;
use App\Modules\WorkFlow\Repository\TranTransOrderRepo;
use Encore\Admin\Facades\Admin;
use App\Modules\WorkFlow\Repository\CommUserRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserUpgradeService extends Service{

    public $user;
    public $trans_order;
    public $inviteCode;
    public function __construct(CommUserRepo $user,TranTransOrderRepo $trans_order,CashOrderRepo $order,InviteCodeRepo $inviteCode)
    {
        $this->user = $user;
        $this->trans_order = $trans_order;
        $this->order = $order;
        $this->inviteCode = $inviteCode;
    }

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    //用户发放邀请码
    public function SendInvCode($request){

        $orderInfo = $this->trans_order->getOrderInfo($request['id']);
        // 查询邀请码数量
        $codeNum = $this->inviteCode->getCodeNum($orderInfo['user_id']);
        if ($codeNum != 0) {
            Err('该用户已发放'.$codeNum);
        }
        switch ($orderInfo['business_code']){
            case 'A1140':  //区代
                $vip = $this->createCode(20,1000,'VIP_USER',$orderInfo['user_id']);
                return $this->inviteCode->insert($vip);
            case 'A1233':  //总代理
                $vip = $this->createCode(5,1000,'VIP_USER',$orderInfo['user_id']);
                return $this->inviteCode->insert($vip);
            case 'A2233':  //合伙人
                $vip = $this->createCode(10,1000,'VIP_USER',$orderInfo['user_id']);
                return $this->inviteCode->insert($vip);
                break;
        }
        return 'false';
    }

    // 参数整理
    public function createCode($number,$amount,$config,$user_id)
    {
        $data = [
            'user_id' => $user_id,
            'old_user_id' => $user_id,
            'state' => '10',
            'create_time' => date('Y-m-d H:i:s'),
            'create_by' => $user_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_by' => $user_id
        ];
        $arr = [];
        for ($i = 0; $i < $number;$i++){
            $data['id'] = ID();
            $data['code'] = strtoupper(MD5(ID()));
            $data['amount'] = $amount;
            $data['level_name'] = config('const_user.'.$config.'.code');
            $arr[] = $data;
        }
        return $arr;
    }

    //用户升级提交审核
    public function userUpgrade($request){

        $userInfo = $this->user->getUserInfo($request['id']);
        $data = array(
            'tariff code' => $userInfo['new_level'],
            'user_id'     => $request['id'],
            'amount'      => $userInfo['trans_amt']
        );

        $url = config('workflow.api').'PmsUserUpgrade.pmsUserUpgrade';

        $arr = [
            'url' => $url,
            'data' => $data,
        ];

        $cls = $this->curlPost($arr);
        $cls = json_decode($cls, true);
        return $cls;
    }

    //用户升级撤回
    public function UpgradeWithdraw($request){
        $userInfo = $this->user->getUserInfo($request['id']);
        $business_code = config('interface.REQUEST_CODE.'.$userInfo['new_level']);

        $param = [
            'user_id'       => $request['id'],
            'business_code' => $business_code,
            'status'        => '5',
        ];
        $orderInfo = $this->trans_order->getOrderInfoByUserId($param);
        if(!$orderInfo){
            return [
                'code'    => '1111',
                'message' => '当前用户没有审核记录'
            ];
        }
        if($orderInfo['status'] != '5'){
            return [
                'code'    => '1111',
                'message' => '当前审核不可驳回'
            ];
        }

        $data = ['status' => '9'];

        $this->trans_order->update($orderInfo['id'],$data);
        $this->order->update($orderInfo['id'],$data);

        return [
            'code'    => '0000',
            'message' => '驳回成功'
        ];
    }

    //用户升级审核通过
    public function UpgradeAdopt($request){

        $orderInfo = $this->trans_order->getOrderInfo($request);
        $data = array(
            'detail_id'     => $orderInfo['id'],
            'business_code' => $orderInfo['business_code'],
            'trans_amt'     => $orderInfo['trans_amt'],
            'user_id'       => $orderInfo['user_id']

        );
        $url = config('workflow.api').'Examine.upgradeAudit';

        $arr = [
            'url' => $url,
            'data' => $data,
        ];
        $cls = $this->curlPost($arr);
        $cls = json_decode($cls, true);
        return $cls;
    }

    //邀请码 用户升级审核通过
    public function inviteUpgradeAdopt($request){
        $orderInfo = $this->trans_order->getOrderInfo($request);
        $data = array(
            'detail_id'     => $orderInfo['id'],
            'business_code' => $orderInfo['business_code'],
            'trans_amt'     => $orderInfo['trans_amt'],
            'user_id'       => $orderInfo['user_id']
        );
        $url = config('workflow.api').'Examine.InviteCodeUpgradeAudit';

        $arr = [
            'url' => $url,
            'data' => $data,
        ];
        $cls = $this->curlPost($arr);
        $cls = json_decode($cls, true);
        return $cls;
    }


    //用户升级驳回
    public function UpgradeReject($request){
        $orderInfo = $this->trans_order->getOrderInfo($request);
        if($orderInfo['status'] != '5'){
            return [
                'code'    => '1111',
                'message' => '当前审核不可驳回'
            ];
        }

        $data = ['status' => '9'];

        $this->trans_order->update($request['id'],$data);
        $this->order->update($request['id'],$data);

        return [
            'code'    => '0000',
            'message' => '驳回成功'
        ];
    }

    public function curlPost($request){
        $options = array(
            CURLOPT_RETURNTRANSFER =>true,
            CURLOPT_HEADER =>false,
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS => $request['data'],
        );
        $ch = curl_init($request['url']);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}