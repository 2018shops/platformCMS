<?php
namespace App\Admin\Controllers\Trans;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\CommUserInfo;
use App\Admin\Models\TranOrder;

use App\Admin\Models\WxPayOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class WeChatController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('微信充值升级流水');
            $content->description('微信充值升级流水');
            $content->body($this->grid());
        });
    }
    public function grid()
    {
        return Admin::grid(WxPayOrder::class,function(Grid $grid) {
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id','订单ID');
            $grid->column('sign','签名');

            $grid->column('body','商品描述');
            $grid->column('total_fee','标价金额(分)');
            $grid->column('spbill_create_ip','终端IP');
            $grid->column('time_start','交易开始时间');
            $grid->column('time_expire','交易结束时间');
            $grid->column('prepayid','交易标识');
            $grid->column('state','订单状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            $grid->column('relation_id','关联流水');
            $grid->column('relation_table','交易类型');
            $grid->column('trans_amt','交易金额')->display(function(){
                return "<span class='label label-success'>".$this->trans_amt."</span>";
            })->sortable();
            $grid->column('trans_time','交易时间')->sortable();
            $grid->column('user.user_id','用户编号');
            $grid->column('user.user_name','用户名');
            $grid->column('user.login_name','手机号');
//            $grid->column('business_code','交易请求码');

            $grid->column('business_code','业务类型')
                ->display(function ($business_code){
                    $msg = $business_code . '->' . config('interface.DICT.'.$business_code .'.msg');
                    return $msg;
                });

            $grid->column('merc_tariff_code','商户资费编码');
            $grid->column('receive_amt','到账金额')->display(function(){
                return "<span class='label label-success'>".$this->trans_amt."</span>";
            })->sortable();
            $grid->column('acct_req_code','财务请求码');
            $grid->column('acct_res_code','记账状态');
            $grid->column('status','交易状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            // 筛选
            $grid->filter(function ($filter) {
                $filter->equal('id','订单ID');
                $filter->equal('user_id','用户编号');
                $filter->equal('state','交易状态');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();

            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(10);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('trans_amt')."</span>");
                $footer->colspan(7);
                $footer->td("<span class='label label-danger'>".$model->sum('receive_amt')."</span>");

            });
        });
    }
}