<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:12
 */

namespace App\Modules\WorkFlow\Service;


use App\Common\Contracts\Service;
use App\Modules\WorkFlow\Repository\MeetingRepo;

class MeetingService extends Service
{

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function updateState(MeetingRepo $meet,$request){

        $arr = [
            'code'    => '0000',
            'message' => '审核成功'
        ];

        $meetInfo = $meet->getMeetInfo($request['id']);
        if($meetInfo['meeting_status'] != '10' ){
            return [
                'code'    => '1111',
                'message' => '当前会议不可审核'
            ];
        }
        $data = [
            'meeting_status' => '20'
        ];
        $ret = $meet->update($request['id'],$data);

        if(!$ret) {
            $arr = [
                'code' => '1111',
                'message' => '审核失败'
            ];
        }
        return $arr;
    }

    public function meetReject(MeetingRepo $meet,$request){
        $arr = [
            'code'    => '0000',
            'message' => '驳回成功'
        ];

        $meetInfo = $meet->getMeetInfo($request['id']);
        if($meetInfo['meeting_status'] != '10' ){
            return [
                'code'    => '1111',
                'message' => '当前会议不可驳回'
            ];
        }
        $data = [
            'meeting_status' => '30'
        ];
        $ret = $meet->update($request['id'],$data);

        if(!$ret) {
            $arr = [
                'code' => '1111',
                'message' => '审核驳回'
            ];
        }
        return $arr;
    }
}