<?php
/**
 * 财务::账单
 * @date 20180602
 */

namespace App\Admin\Controllers\Finance;

use App\Admin\Contracts\Facades\Admin;

use App\Admin\Contracts\Grid;
use App\Admin\Models\AcctBookingOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Layout\Content;

class BookingController extends Controller{

    use ModelForm;


    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('账单明细');
            $content->description('账单明细');
            $content->body($this->grid());
        });
    }


    public function grid()
    {

        return Admin::grid(AcctBookingOrder::class,function(Grid $grid){
            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->model()->orderBy('create_time', 'desc');
            //$grid->column('id',"ID");
            $grid->column('batch_id','批次号')->sortable();
            $grid->column('voucher_code','请求码')->sortable();
            $grid->column('batch_detail_id','序号')->sortable();
            //$grid->column('account_id','账套')->sortable();

            //$grid->column('general_account_code','总账')->sortable();

            $grid->column('account_category','类别')
                ->display(function($account_category){
                    return "<span class='label label-default'>".$this->general_account_code."</span><br/><span class='label label-default'>".config('selection.finance.account_category.'.$account_category)."</span>";
                })->sortable();

            // $grid->column('account_object','账户对象')
            //     ->display(function($acct){
            //         return config('selection.finance.object.'.$acct);
            //     })->sortable();
            $grid->column('process_id','账户编号')->display(function($process_id){
                return "<span class='label label-default'>".config('selection.finance.object.'.$this->account_object)."</span><br/><span class='label label-info'>".$process_id."</span>";
            })->sortable();
            $grid->column('account_type','账户类型')
                ->display(function($type){
                    return config('selection.finance.type.'.$type);
                })->sortable();
            $grid->column('user.user_name','用户信息')->display(function(){
                if($this->user)
                    return "<span class='label label-info'><b>".$this->user['user_name']."</b></span><br/><span class='label label-primary'>(".$this->user['login_name'].")</span>";
                else
                    return "";
            });
            //$grid->column('user.login_name','手机号')->sortable();

            $grid->column('debit_amount','借')->display(function(){
                return "<span class='label label-success'>".$this->debit_amount."</span>";
            })->sortable();
            $grid->column('credit_amount','贷')->display(function(){
                return "<span class='label label-danger'>".$this->credit_amount."</span>";
            })->sortable();
            $grid->column('debit_credit_direction','借贷方向')
                ->display(function($debit_credit_direction){
                    return config('selection.finance.debit_credit_direction.'.$debit_credit_direction);
                })->sortable();
            $grid->column('external_con_order','收银流水')->sortable();
            $grid->column('remark','摘要');
            $grid->column('account_status','录入状态')
                ->display(function($account_status){
                    return config('selection.finance.account_status.'.$account_status);
                })->sortable();
            $grid->column('account_balance_status','记账状态')
                ->display(function($account_balance_status){
                    return config('selection.finance.account_balance_status.'.$account_balance_status);
                })->sortable();
            $grid->column('account_balance_time','记账时间')->sortable();
            $grid->column('reset_booking_order','反记账流水')->sortable();
            //$grid->column('reset_booking_reason','反记账理由')->sortable();
            //$grid->column('status','状态')->sortable();

            $grid->filter(function($filter){
                $filter->like('voucher_code','请求码');
                $filter->like('batch_id','批次号');
                $filter->like('process_id','账户编号');
                $filter->like('external_con_order','收银流水');
                $filter->like('account_balance_status','记账状态')->select(config('selection.finance.account_balance_status'));
                $filter->like('account_object','账户对象')->select(config('selection.finance.object'));
                $filter->like('account_type','账户类型')->select(config('selection.finance.type'));
            });

            $grid->column('update_time','更新时间')->sortable();
            //$grid->column('created_at','生成时间')->sortable();
            //这里是底部合计
            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(6);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-success'>".$model->sum('debit_amount')."</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('credit_amount')."</span>");

            });
        });
    }
}