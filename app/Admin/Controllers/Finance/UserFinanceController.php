<?php
/**
 * 财务:部门绩效
 * @date 20180602
 */

namespace App\Admin\Controllers\Finance;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctFinance;
use App\Admin\Models\UserAcctFinance;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class UserFinanceController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('部门绩效');
            $content->description('部门绩效');
            $content->body($this->grid());
        });
    }


    public function grid()
    {
        return Admin::grid(UserAcctFinance::class,function(Grid $grid){
            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->column('id',"ID");
            $grid->column('account_type','账户类型')
                ->display(function($type){
                    return config('selection.finance.type.'.$type);
                });
            $grid->column('account_object','账户对象')
                ->display(function($acct){
                    return config('selection.finance.object.'.$acct);
                });
            $grid->column('process_id','关联ID');

            $grid->column('user_name','部门名称')
                ->display(function($acct){
                    return config('finance.depart.'.$acct);
                });
            $grid->column('login_name','手机号');
            $grid->column('balance','余额');
            $grid->column('opening_balance','期初余额');
            $grid->column('occurred_amount','发生额');

            $grid->column('direction','借贷方向')
                ->display(function($direction){
                    return config('selection.finance.debit_credit_direction.'.$direction)??'';
                });

            $grid->column('closing_order','期末凭证');

            $grid->filter(function($filter){
                $filter->like('user_name','用户名');
                $filter->like('login_name','手机号');
            });

            $grid->column('update_time','更新时间');
        });
    }
}