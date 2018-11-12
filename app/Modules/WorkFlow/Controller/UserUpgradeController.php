<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:51
 * desc 用户升级
 */

namespace App\Modules\WorkFlow\Controller;


use App\Http\Controllers\Controller;
use App\Modules\WorkFlow\WorkFlow;
use Illuminate\Http\Request;

class UserUpgradeController extends Controller
{
    //用户发放邀请码
    public function SendInvCode(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('SendInvCode');
    }
    //用户升级审核撤回
    public function UpgradeWithdraw(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('UpgradeWithdraw');
    }
    //用户升级审核提交
    public function UserUpgrade(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('userUpgrade');
    }

    //用户升级通过审核
    public function UpgradeAdopt(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('UpgradeAdopt');
    }

    //邀请码用户升级通过审核
    public function inviteUpgradeAdopt(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('inviteUpgradeAdopt');
    }

    //用户升级驳回
    public function UpgradeReject(Request $request){
        return WorkFlow::service('UserUpgradeService')
            ->with('id',$request->input('id'))
            ->run('UpgradeReject');
    }
}