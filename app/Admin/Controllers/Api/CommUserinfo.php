<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 13:50
 */

namespace App\Admin\Controllers\Api;


use App\Admin\Models\CommUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommUserinfo extends Controller
{
    public function getUserByUserid(Request $request)
    {
        $q = $request->input('q');
        $ret =   optional(CommUser::where('id','like','%'.$q.'%')
            ->paginate(null,['id','user_name as text']))->toArray();
        return ($ret);
    }
}