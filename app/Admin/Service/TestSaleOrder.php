<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/7
 * Time: 16:44
 */

namespace App\Admin\Service;
use App\Common\Contracts\Service;

class TestSaleOrder extends Service{
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }


    public function handle($request)
    {
        $request['new'] = "newnewnew";
        return $request;
    }


}