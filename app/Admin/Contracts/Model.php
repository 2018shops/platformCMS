<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/1
 * Time: 17:50
 */
namespace App\Admin\Contracts ;

use Encore\Admin\Grid\Model as EncoreGridModel;

class Model extends EncoreGridModel {


    public function getQueries()
    {
        return $this->queries;
    }
}