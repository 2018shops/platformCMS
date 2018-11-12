<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\CommUser;
use App\Common\Contracts\Repository;

class CommUserRepo extends Repository{
    public function __construct(CommUser $model)
    {
        $this->model = $model;
    }

    //获取用户信息
    public function getUserInfo($user_id){
        return optional($this->model
        ->select('id','trans_amt','new_level')
        ->where('user_id',$user_id)
        ->first())
        ->toArray();
    }

    public function update($id, $data)
    {
        return $this->model->where('id',$id)->update($data);
    }
}