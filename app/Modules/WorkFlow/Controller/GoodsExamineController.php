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

class GoodsExamineController extends Controller{
    /**
     * @desc 商品审核通过
     */
    public function goodsExaminePass(Request $request){
        return WorkFlow::service('GoodsExamineService')
            ->with('id',$request->input('id'))
            ->run('goodsExaminePass');
    }
     /**
      * @desc 圣品审核拒绝
      */
    public function goodsExamineRefuse(Request $request){
        return WorkFlow::service('GoodsExamineService')
            ->with('id',$request->input('id'))
            ->with('text',$request->input('text'))
            ->run('goodsExamineRefuse');
    }
}
