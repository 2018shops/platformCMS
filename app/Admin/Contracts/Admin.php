<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/1
 * Time: 18:09
 */
namespace App\Admin\Contracts ;
use Encore\Admin\Admin as EncoreAdmin ;
use Closure;


class Admin extends EncoreAdmin {


    public function grid($model, Closure $callable)
    {
        return new Grid($this->getModel($model), $callable);
    }

    public function service($service)
    {
        $service = "App\\Admin\\Service\\".$service;
        return app()->make($service);
    }

}