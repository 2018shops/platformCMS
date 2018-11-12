<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:16
 */

namespace App\Modules\WorkFlow\Repository;


use App\Admin\Models\MeetingInfo;
use App\Common\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

class MeetingRepo extends Repository
{
    public function __construct(MeetingInfo $model)
    {
        $this->model = $model;
    }

    public function getMeetInfo($id){
        return optional(
            $this->model
                ->select('meeting_status')
                ->where('id',$id)
                ->first())
            ->toArray();
    }

    public function update($id, $attributes)
    {
        return $this->model->where('id',$id)->update($attributes);
    }
}