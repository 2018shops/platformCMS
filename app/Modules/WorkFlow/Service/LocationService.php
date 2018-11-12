<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:41
 */

namespace App\Modules\WorkFlow\Service;


use App\Common\Contracts\Service;
use App\Modules\WorkFlow\WorkFlow;

class LocationService extends Service
{
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function getCoordinate($request){

        $url = config('workflow.api').'Location.getCoordinate';

        $options = array(
            CURLOPT_RETURNTRANSFER =>true,
            CURLOPT_HEADER =>false,
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS => $request,
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        $ret = json_decode($result);
        $data = $ret->data;
        if($data->status == 0){
            return $data->result->location->lat . ',' . $data->result->location->lng;
        }else{
//            Err('请填写正确的地址');
        }
    }
}