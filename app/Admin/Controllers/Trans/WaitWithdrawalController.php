<?php
namespace App\Admin\Controllers\Trans;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExcelExporter\ExportWaitPay;
use App\Admin\Fields\ExcelExportr;
use App\Admin\Models\CommUserInfo;
use App\Admin\Models\TranOrder;
use App\Admin\Models\TranTransOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class WaitWithdrawalController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('代付流水');
            $content->description('代付流水');
            $content->body($this->grid());
        });
    }
    public function grid()
    {
        return Admin::grid(TranTransOrder::class,function(Grid $grid) {
            $todayEnd= date('Y-m-d 23:59:59', time());
            $grid->model()->orderBy('create_time', 'desc');
            $grid->model()->where('business_code', '=', 'A0715');
            $grid->model()->where('status', '=', '2');
            $grid->model()->where('receive_time', '<=', $todayEnd);
            $grid->column('id','流水ID');
            $grid->column('business_code','业务码');

            $grid->column('user.user_name','用户名');
            $grid->column('user.account_name','开户名');
            $grid->column('user.crp_id_no','证件号');
            $grid->column('user.open_bank_name','银行名称');
            $grid->column('user.bank_line_name','开户行');
            //    ->display(function($limit) {
            //    return str_limit($limit, 18, '...');
            //});;
            // $grid->column('user.regist_address','地址');

            $grid->column('trans_amt','交易');
            $grid->column('trans_time','交易时间')->sortable();
            $grid->column('receive_amt','到账');
            $grid->column('receive_time','到帐时间')->sortable();
            $grid->column('user_id','用户编号');

            $grid->column('status','状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            $grid->column('cash_type','类型');
            // $grid->column('agent_id','代理商编号')->sortable();
            $grid->exporter(new ExportWaitPay());
            $grid->column('channel_id','通道ID')->sortable();
            $grid->column('channel_merc_id','通道商户')->sortable();
            $grid->column('acct_req_code','财务码')->sortable();
            $grid->column('update_time','更新时间')->sortable();

            // 筛选
            $grid->filter(function ($filter) {
                $filter->equal('id','流水ID');
                $filter->equal('user_name','用户名');
                $filter->equal('user.crp_id_no','证件号');
                $filter->equal('trans_time','交易时间');
                $filter->equal('user_id','用户编号');
                $filter->equal('status','状态');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}