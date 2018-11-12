<?php
/**
 * 财务:记账模板
 * @20180602
 */
namespace App\Admin\Controllers\Finance;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctBookingTemplet;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class AcctTempletController extends Controller{

    use ModelForm;


    public function index()
    {

        return Admin::content(function( Content $content){
            $content->header('记账模板');
            $content->description('记账模板');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function( Content $content){

            $content->header('新增记账模板');
            $content->description('新增记账模板');
            $content->body($this->form());
        });
    }


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑记账模板');
            $content->description('编辑记账模板');
            $content->body($this->form()->edit($id));
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('记账模板信息');
            $content->description('记账模板详情');
            $content->body($this->detail()->view($id));
        });
    }

    public function grid()
    {

        return Admin::grid(AcctBookingTemplet::class,function(Grid $grid){
            //$grid->model()->orderby('update_time', 'desc');
            $grid->column('id',"ID")->display(function($text) {
                return substr($text, 12);
            })->sortable();
            $grid->column('voucher_code','请求码')->sortable();
            $grid->column('voucher_batch_id','序号')->sortable();
//            $grid->column('voucher_name','凭证名称')->display(function($text) {
//                return str_limit($text, 16,'.');
//            })->sortable();
            $grid->column('voucher_name','凭证名称')->sortable()->display(function ($voucher_name) {
                return "<a href='/admin/finance/templet/{$this->getKey()}' class=''><b>$voucher_name</b></a>";
            });
            //$grid->column('account_id','账套Bean')->sortable();
            // $grid->column('account_id','账套Bean')
            //     ->display(function($account_id){
            //         return config('selection.finance.account_id.'.$account_id);
            //     })->sortable();
            $grid->column('general_account_code','总账科目')
                ->display(function($general_account_code){
                    return config('selection.finance.general_account_code.'.$general_account_code);
                })->sortable();
            $grid->column('account_type','账户类型')
                ->display(function($type){
                    return config('selection.finance.type.'.$type);
                })->sortable();
            $grid->column('account_object','账户对象')
                ->display(function($acct){
                    return config('selection.finance.object.'.$acct);
                })->sortable();
            $grid->column('process_bean','编号Bean')->sortable();
            $grid->column('process_id','关联ID')->sortable();

            $grid->column('debit_amount_bean','借方Bean')->sortable();
            $grid->column('credit_amount_bean','贷方Bean')->sortable();
            $grid->column('debit_amount','借方额')->sortable();
            $grid->column('credit_amount','贷方额')->sortable();
            $grid->column('debit_credit_direction','借贷方向')
                ->display(function($debit_credit_direction){
                    return config('selection.finance.debit_credit_direction.'.$debit_credit_direction);
                })->sortable();
            // $grid->column('external_con_order','外联Bean')
            //     ->display(function($external_con_order){
            //         return config('selection.finance.external_con_order.'.$external_con_order);
            //     })->sortable();
            $grid->column('use_status','状态')
                ->display(function($use_status){
                    return config('selection.finance.use_status.'.$use_status);
                })->sortable();

            $grid->filter(function($filter){
                $filter->like('voucher_code','请求码');
                $filter->like('voucher_name','凭证名称');
                //$filter->like('account_object','账户对象')->select(config('selection.finance.object'));
                //$filter->like('account_type','账户类型')->select(config('selection.finance.type'));
                //$filter->like('general_account_code','总账类型')->select(config('selection.finance.general_account_code'));
            });

            $grid->column('update_time','更新时间')->sortable();
            //$grid->column('created_at','生成时间')->sortable();
        });
    }

    public function form()
    {
        return Admin::form(AcctBookingTemplet::class,function(Form $form){

            $form->tab('基本数据',function(Form $form){
                $form->hidden('id','ID');
                $form->text('voucher_code','请求码');
                $form->select('voucher_batch_id','序号')->options(['请选择','1','2','3','4','5','6','7','8','9']);
                $form->text('voucher_name','凭证名称');
                $form->select('account_id','账套Bean')
                    ->options(config('selection.finance.account_id'));
                $form->select('debit_credit_direction','借贷方向')
                    ->options(config('selection.finance.debit_credit_direction'));
                $form->select('external_con_order','外联Bean')
                    ->options(config('selection.finance.external_con_order'));
                $states = [
                    'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
                ];
                $form->switch('use_status','状态')->states($states);
            });


            $form->tab('账户属性',function(Form $form){
                $form->select('general_account_code','总账科目')
                    ->options(config('selection.finance.general_account_code'));
                $form->select('account_type','账户类型')
                    ->options(config('selection.finance.type'));
                $form->select('account_object','账户对象')
                    ->options(config('selection.finance.object'));
            });
            $form->tab('变量设置',function(Form $form){
                $form->text('process_bean','编号Bean');
                $form->text('debit_amount_bean','借方Bean');
                $form->text('credit_amount_bean','贷方Bean');
            });
            $form->tab('常量设置',function(Form $form){
                $form->text('process_id','编号');
                $form->text('debit_amount','借方额');
                $form->text('credit_amount','贷方额');

            });
            $form->tab('简介描述',function(Form $form){
                $form->editor('brief','简介');
            });
            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });

            $form->saved(function(Form $form){

            });
        });
    }

    public function detail()
    {
        return Admin::form(AcctBookingTemplet::class,function(Form $form){

            $form->tab('记账模型',function(Form $form){
                $form->display('brief','简介');
            });

            $form->tab('基本数据',function(Form $form){
                $form->display('id','ID');
                $form->display('voucher_code','请求码');
                $form->display('voucher_batch_id','序号');
                $form->display('voucher_name','凭证名称');
                $form->display('account_id', '账套Bean')->with(function ($account_id){
                    return config('selection.finance.account_id.'.$account_id);
                });

                $form->display('debit_credit_direction', '借贷方向')->with(function ($debit_credit_direction){
                    return config('selection.finance.debit_credit_direction.'.$debit_credit_direction);
                });
                $form->display('external_con_order', '外联Bean')->with(function ($external_con_order){
                    return config('selection.finance.external_con_order.'.$external_con_order);
                });
                $states = [
                    'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
                    'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
                ];
                $form->switch('use_status','状态')->states($states);
            });
            $form->tab('账户属性',function(Form $form){

                $form->display('general_account_code', '总账科目')->with(function ($general_account_code){
                    return config('selection.finance.general_account_code.'.$general_account_code);
                });
                $form->display('account_type', '账户类型')->with(function ($account_type){
                    return config('selection.finance.type.'.$account_type);
                });
                $form->display('account_object', '账户对象')->with(function ($account_object){
                    return config('selection.finance.object.'.$account_object);
                });

            });
            $form->tab('变量设置',function(Form $form){
                $form->display('process_bean','编号Bean');
                $form->display('debit_amount_bean','借方Bean');
                $form->display('credit_amount_bean','贷方Bean');
            });
            $form->tab('常量设置',function(Form $form){
                $form->display('process_id','编号');
                $form->display('debit_amount','借方额');
                $form->display('credit_amount','贷方额');

            });
            $form->disableSubmit();//隐藏保存按钮
            $form->disableReset(); //去掉重置按钮
        });
    }
}