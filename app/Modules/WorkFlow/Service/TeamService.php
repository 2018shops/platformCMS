<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4
 * Time: 13:41
 */

namespace App\Modules\WorkFlow\Service;
use Illuminate\Http\Request;
use App\Common\Contracts\Service;
use App\Modules\WorkFlow\WorkFlow;

class TeamService extends Service
{
    public function getRules(){

    }
    public function getSuperiorRecommendAll($request){
        $arr['status'] = '';
        $data = [
            'user_id' => $request['user_id']
        ];

        $url = config('workflow.api').'Team.getSuperiorRecommendAll';

        $ret = WorkFlow::service('UserUpgradeService')
            ->with('url',$url)
            ->with('data',$data)
            ->run('curlPost');

        $ret = json_decode($ret);

        if($ret->code == '0000'){
            $arr['status'] = $ret->code;

            foreach($ret->data as $key => $val){
                if($val->user_id != '0'){
                    $arr['data'][$key]['user_id'] = $val->user_id;
                    $arr['data'][$key]['user_name'] = $val->user_name;
                    $arr['data'][$key]['level_name'] = config('const_user.'.$val->user_tariff_code . '.msg');
                }else{
                    $arr['data'][$key]['user_id'] = '';
                    $arr['data'][$key]['user_name'] = '';
                    $arr['data'][$key]['level_name'] = config('const_user.'.$val->user_tariff_code . '.msg');
                }

            }
            return $arr;
        }
        return $arr;
    }

    public function getThreeLevelRecommend($request){
        $arr['status'] = '';
        $data = [
            'user_id' => $request['user_id']
        ];

        $url = config('workflow.api').'Team.getABCRecommendAll';

        $ret = WorkFlow::service('UserUpgradeService')
            ->with('url',$url)
            ->with('data',$data)
            ->run('curlPost');

        $ret = json_decode($ret);
        if($ret->code == '0000'){
            $arr['status'] = $ret->code;
            $i = 0;
            foreach($ret->data as $key => $val){
                $arr['data'][$i]['user_id'] = $val->user_id;
                $arr['data'][$i]['user_name'] = $val->user_name;
                $arr['data'][$i]['level_name'] = config('const_user.'. $key . '.msg');
                $i++;
            }
            return $arr;
        }
        return $arr;
    }
}