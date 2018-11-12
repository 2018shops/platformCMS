<?php
/**
 * 工作流
 */
namespace App\Modules\WorkFlow\Controller;

use Illuminate\Http\Request;
use App\Modules\WorkFlow\WorkFlow;
use App\Http\Controllers\Controller;

/**
 * 驳回接口
 */

class RejectController extends Controller {

    public function index(Request $request)
    {
        $module = $request->input('m');
        $id = $request->input('id');
        $ret =  WorkFlow::service('Reject')->with('id',$id)->with('module',$module)->run();
        return response()->json($ret);
    }
    
}