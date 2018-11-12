<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 17:40
 */

namespace App\Admin\Middleware\WorkFlow ;
use App\Common\Contracts\Middleware;
use Closure;

class SaleOrder extends Middleware {

    public function handle($request, Closure $next)
    {
        $request['middle1'] = 'sale_order';


        return $next($request);
    }


}