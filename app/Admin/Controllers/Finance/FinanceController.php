<?php
/**
 * 财务:账户余额
 * @date 20180602
 */

namespace App\Admin\Controllers\Finance;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctFinance;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use App\Admin\Contracts\Grid;
use Encore\Admin\Layout\Content;

class FinanceController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('余额');
            $content->description('余额列表');
            $content->body($this->grid());
        });
    }


    public function grid()
    {
        return Admin::grid(AcctFinance::class,function(Grid $grid){
            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->column('id',"ID");
            $grid->column('account_id','账套')->sortable();
            $grid->column('account_type','账户类型')
                ->display(function($type){
                    return config('selection.finance.type.'.$type);
                })->sortable();
            $grid->column('account_object','账户对象')
                ->display(function($acct){
                    return config('selection.finance.object.'.$acct);
                })->sortable();
            $grid->column('process_id','关联ID')->sortable();
            $grid->column('user.user_name','用户名')->sortable();
            $grid->column('user.level_name','用户等级')
                ->display(function($level_name){
                    if($level_name)
                        return config('const_user.USER_LARAVEL.'.$level_name);
                    else
                        return "";
            })->sortable();
            $grid->column('user.login_name','手机号')->sortable();
//            $grid->column('balance','余额')->sortable();
            $grid->column('balance','余额')->display(function(){
                return "<span class='label label-success'>".$this->balance."</span>";
            })->sortable();
            $grid->column('opening_balance','期初余额')->display(function(){
                return "<span class='label label-success'>".$this->opening_balance."</span>";
            })->sortable();
            $grid->column('occurred_amount','发生额')->display(function(){
                return "<span class='label label-success'>".$this->occurred_amount."</span>";
            })->sortable();

            $grid->column('direction','借贷方向')
                ->display(function($direction){
                    return config('selection.finance.debit_credit_direction.'.$direction)??'';
                })->sortable();

            $grid->column('closing_order','期末凭证')->sortable();
            //$grid->column('status','状态')->sortable();

            $grid->filter(function($filter){
                $filter->like('process_id','账户编号');
                $filter->like('user.user_name','用户名');
                $filter->like('user.login_name','手机号');
                $filter->like('user.level_name','用户等级')->select(config('const_user.USER_LARAVEL'));
                $filter->like('account_object','账户对象')->select(config('selection.finance.object'));
                $filter->like('account_type','账户类型')->select(config('selection.finance.type'));
                $filter->like('balance','余额');
            });

            $grid->column('update_time','更新时间')->sortable();

            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(7);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('balance')."</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('opening_balance')."</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('occurred_amount')."</span>");

            });
            //$grid->column('created_at','生成时间')->sortable();
        });
    }
}