<?php
/**
 * Created by PhpStorm.
 * User: langfl
 * Date: 2018/06/19
 * Time: 17:29
 */
//审批 检查
namespace App\Modules\WorkFlow\Service;
use App\Common\Contracts\Service;
use Encore\Admin\Facades\Admin;
use App\Modules\WorkFlow\Repository\GoodsClassifyRepo;


class GoodsClassifyService extends Service {

    public function __construct(GoodsClassifyRepo $class)
    {
        $this->class = $class;
    }

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function getGoodsClassify(){
        $ret = $this->class->getGoodsClassify();
        return $ret;
    }
}