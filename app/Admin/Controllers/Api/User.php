<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/14
 * Time: 11:35
 */
namespace App\Admin\Controllers\Api ;
use App\Admin\Models\CommUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Controller {

    public function getUsers(Request $request)
    {
        $q = $request->input('q');
        $ret =   optional(Administrator::where('username','like','%'.$q.'%')
            ->paginate(null,['id','username as text']))->toArray();

        return ($ret['data']);
    }

    public function getId()
    {
        $ret = optional(CommUser::select('id','user_name as text')->paginate('10'))->toArray();
        return $ret['data'];
    }

    public function backUsers(Request $request)
    {

        $arr = $request->all();
        $recArr['status'] = '30';
        $recArr['crp_nm'] = '';
        $recArr['crp_id_type'] = '';
        $recArr['crp_id_no'] = '';
        $recArr['account_name'] = '';
        $recArr['account_no'] = '';
        $recArr['bank_reserved_mobile'] = '';
        $recArr['regist_address'] = '';
        $recArr['open_bank_name'] = '';
        $recArr['bank_line_name'] = '';
        $recArr['bank_code'] = '';
        $ret = CommUser::where('id',$arr['id'])->update($recArr);
        if(!$ret){
            return '打回失败';
        }
        return [
            'code' => '0000',
            'message' => '打回成功!',
        ];
    }


    public function gets()
    {
        $html = "";
    }
}