<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 15:14
 */

namespace App\Modules\WorkFlow\Service;


use App\Common\Contracts\Service;
use App\Modules\WorkFlow\WorkFlow;

class JpushService extends Service
{
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function singlePushPms($request){
        $url = config('workflow.api').'JPush.singlePushPms';
        $cls = WorkFlow::service('UserUpgradeService')
            ->with('url',$url)
            ->with('data',$request)
            ->run('curlPost');

        $cls = json_decode($cls, true);
        return $cls;
    }
}