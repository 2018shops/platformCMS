<?php
/**
 * 商品分类
 */
namespace App\Modules\WorkFlow\Controller;

use Illuminate\Http\Request;
use App\Modules\WorkFlow\WorkFlow;
use App\Http\Controllers\Controller;

/**
 * 审批接口
 */

class GoodsClassifyController extends Controller 
{
    //获取商品分类
    public function getGoodsClassify(Request $request){
        $data = [
            ['id' => 1,'text'=>'ssssssss'],
            ['id' => 2,'text'=>'wwwwwwww'],
        ];
        return json_encode($data);
        return response()->json();
        
        $ret = WorkFlow::service('GoodsClassifyService')
            ->run('getGoodsClassify');
            dd($ret);
        //     $data['data'] = ['id' => '1', '01' => '线下'];
        // return $data;
        return $ret;
    }
}
