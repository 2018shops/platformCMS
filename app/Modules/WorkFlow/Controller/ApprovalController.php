<?php
/**
 * 工作流
 */
namespace App\Modules\WorkFlow\Controller;

use Illuminate\Http\Request;
use App\Modules\WorkFlow\WorkFlow;
use App\Http\Controllers\Controller;

/**
 * 审批接口
 */

class ApprovalController extends Controller {

    public function index(Request $request)
    {
        $module = $request->input('m');
        $id = $request->input('id');
        $ret =  WorkFlow::service('Launch')
            ->with('id',$request->input('id'))
            ->with('module',$request->input('m'))
            ->with('state',$request->input('state'))
            ->run();
        return response()->json($ret);
    }
    
}