<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 14:16
 */
namespace App\Modules\WorkFlow;
use Illuminate\Support\Facades\Facade;

class WorkFlow extends Facade {

    public static function getFacadeAccessor(){
        return 'app-workflow';
    }
}