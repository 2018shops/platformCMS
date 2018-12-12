<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\GoodsClassify;
use App\Common\Contracts\Repository;
use Illuminate\Support\Facades\DB;

class GoodsClassifyRepo extends Repository{
    public function __construct(GoodsClassify $model)
    {
        $this->model = $model;
    }

    public function getGoodsClassify(){
        // $ret = GoodsClassify::where('status',1)->paginate(null, ['id', 'name as text']);
        // dd($ret);
        $ret = optional($this->model
            ->select('id','name as text')
            ->where('status',1)
            ->paginate(15))
            ->toArray();
        return $ret;
    }
}