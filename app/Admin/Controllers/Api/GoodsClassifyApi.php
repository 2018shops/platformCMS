<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 13:50
 */

namespace App\Admin\Controllers\Api;


use App\Admin\Models\GoodsClassify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsClassifyApi extends Controller
{
    public function getGoodsClassify(Request $request)
    {
        // $q = $request->input('q');
        $ret = optional(GoodsClassify::where('status',1)
            ->paginate(null,['id','name as text']))->toArray();
        return $ret;
    }
}