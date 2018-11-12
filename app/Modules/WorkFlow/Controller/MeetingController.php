<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:08
 */

namespace App\Modules\WorkFlow\Controller;


use App\Http\Controllers\Controller;
use App\Modules\WorkFlow\WorkFlow;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * @desr 修改会议状态
     */
    public function updateState(Request $request){
        return WorkFlow::service('MeetingService')
            ->with('id',$request->input('id'))
            ->run('updateState');
    }

    /**
     * @desr 修改会议状态
     */
    public function meetReject(Request $request){
        return WorkFlow::service('MeetingService')
            ->with('id',$request->input('id'))
            ->run('meetReject');
    }
}