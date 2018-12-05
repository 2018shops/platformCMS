<?php
/**
 * 工作流
 */
namespace App\Modules\WorkFlow\Controller;

use Illuminate\Http\Request;
use App\Modules\WorkFlow\WorkFlow;
use App\Http\Controllers\Controller;
/**
 * 店铺
 */

class StoreController extends Controller {

    /**
     * @desc 店铺审核通过
     */
    public function storePass(Request $request)
    {
        return WorkFlow::service('StoreService')
            ->with('id',$request->input('id'))
            ->run('storePass');
    }

    /**
     * @desc 店铺审核拒绝
     */
    public function storeRefuse(Request $request){
        return WorkFlow::service('StoreService')
            ->with('id',$request->input('id'))
            ->with('text',$request->input('text'))
            ->run('storeRefuse');
    }

    /**
     * @desc 店铺强制禁用
     */
    public function storeProhibit(Request $request){
        return WorkFlow::service('StoreService')
            ->with('id',$request->input('id'))
            ->with('text',$request->input('text'))
            ->run('storeProhibit');
    }
    
}