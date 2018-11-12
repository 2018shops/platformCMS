<?php

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\InviteCode;
use App\Common\Contracts\Repository;

class InviteCodeRepo extends Repository
{
    public function __construct(InviteCode $model)
    {
        $this->model = $model;
    }
    public function getCodeNum($userId)
    {
        $ret = $this->model
            ->select('id')
            ->where('user_id',$userId)
            ->count();
        return $ret;
    }
}