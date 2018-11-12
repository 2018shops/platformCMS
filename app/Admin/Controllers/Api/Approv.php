<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/6/19
 * Time: 14:31
 */

namespace App\Admin\Controllers\Api ;

use App\Admin\Models\ApprovRecord;
use App\Admin\Models\CommUser;
use App\Admin\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Approv extends Controller {
    public static function approvDetails($request){
        
        $ret = ApprovRecord::getModuleName($request);
        switch($ret->module_name){
            case 'customer' : 
                $customerInfo = Customer::getCustomerName($request);
                $name = '';
                if(isset($customerInfo->name)){
                    $name = $customerInfo->name;
                }
                return "<a href='/admin/sale/customer/{$request}' class=''><b>$name</b></a>";
            case 'userupgrade':
                $userInfo = CommUser::getUserName($request);
                $name = '';
                if(isset($userInfo->user_name)){
                    $name = $userInfo->user_name;
                }
                return "<a href='/admin/user/users/{$request}' class=''><b>$name</b></a>";
        }
    }   
}
