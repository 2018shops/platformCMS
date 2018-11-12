<?php
namespace App\Admin\Controllers\Trans;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\CashOrder;
use App\Admin\Models\CommUserInfo;
use App\Admin\Models\TranOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class SummaryController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('收银流水');
            $content->description('收银流水');
            $content->body($this->grid());
        });
    }
    public function grid()
    {
        return Admin::grid(CashOrder::class,function(Grid $grid) {
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id','收银流水ID');
            $grid->column('relation_id','关联流水');
            $grid->column('relation_table','交易类型');
            $grid->column('trans_amt','交易金额')->display(function(){
                return "<span class='label label-success'>".$this->trans_amt."</span>";
            })->sortable();
            $grid->column('trans_time','交易时间')->sortable();
            $grid->column('user_id','用户编号');
            $grid->column('user_name','用户名');
            $grid->column('user.login_name','手机号');
            $grid->column('business_code','交易请求码');
            $grid->column('merc_tariff_code','商户资费编码');
            $grid->column('receive_amt','到账金额')->display(function(){
                return "<span class='label label-success'>".$this->receive_amt."</span>";
            })->sortable();
            $grid->column('acct_req_code','财务请求码');
            $grid->column('acct_res_code','记账状态');
            $grid->column('status','交易状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            $grid->column('update_time','更新时间')->sortable();
            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('relation_id','关联流水');
                $filter->like('user_name','用户名');
                $filter->like('business_code','业务类型');
                $filter->like('user_id','用户编号');
                $filter->like('user.login_name','手机号');
                $filter->like('merc_tariff_code','资费编码');
                $filter->like('status','交易状态')->select(config('const_trans.summary_status'));
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(2);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('trans_amt')."</span>");
                $footer->colspan(7);
                $footer->td("<span class='label label-danger'>".$model->sum('receive_amt')."</span>");

            });
        });
    }
}