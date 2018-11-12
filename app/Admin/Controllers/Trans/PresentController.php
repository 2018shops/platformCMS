<?php
namespace App\Admin\Controllers\Trans;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\CommUserInfo;
use App\Admin\Models\RedPacket;
use App\Admin\Models\TranOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class PresentController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('红包信息');
            $content->description('红包信息');
            $content->body($this->grid());
        });
    }
    public function grid()
    {
        return Admin::grid(RedPacket::class,function(Grid $grid) {
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id','红包ID');
            $grid->column('packet_name','红包名称');
            $grid->column('packet_amount','红包金额');
            $grid->column('granting_object','发放对象');
            $grid->column('create_time','发放时间')->sortable();
            $grid->column('desr','描述');
            $grid->column('status','状态')
                ->display(function ($status){
                    return config('const_trans.double_status.'.$status);
                });
            $grid->column('update_time','更新时间')->sortable();
            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('id','红包ID');
                $filter->like('packet_name','红包名称');
                $filter->like('granting_object','发放对象');
                $filter->like('desr','描述');
                $filter->like('create_time','发放时间');
                $filter->like('status','状态');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();

            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(7);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('packet_amount')."</span>");

            });
        });
    }
}