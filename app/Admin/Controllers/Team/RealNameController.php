<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/2/27
 * Time: 11:57
 */
namespace App\Admin\Controllers\Team ;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExtendButton;
use App\Admin\Middleware\WorkFlow\SaleOrder;
use App\Admin\Models\CommUser;
use App\Http\Controllers\Controller;

use App\Modules\WorkFlow\WorkFlow;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class RealNameController extends Controller {

    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('实名用户管理');
            $content->description('实名用户列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('实名用户修改');
            $content->description('实名用户信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('用户信息');
            $content->description('用户信息');
            $content->body($this->detail()->view($id));
        });
    }

    public function grid()
    {
       return Admin::grid(CommUser::class, function (Grid $grid){

            $grid->disableCreateButton();
            $grid->disableExport();
//            $grid->disableActions();

            $grid->model()->where('status', '60');
            $grid->model()->orderBy('create_time', 'desc');


            $grid->column('user_id','ID')->sortable();
            $grid->column('user_name','用户名')->sortable();
            $grid->column('login_name','手机号')->sortable();
            $grid->column('account_no','银行卡号')->sortable();
            $grid->column('crp_id_no','身份证号')->sortable();
            $grid->column('bank_reserved_mobile','银行卡预留手机号')->sortable();
            $grid->column('regist_address','注册地址')->sortable();
            $grid->column('open_bank_name','开户行')->sortable();
            $grid->column('bank_line_name','开户行名称')->sortable();

//
            $grid->column('level_name','用户资费')->display(function ($level_name) {
               // $count = count($level_name);
               return "<span class='label label-primary'>{$level_name}</span>";
            });
//
//            $grid->column('user_tariff_code','用户等级')->display(function($level){
//               return config('const_user.'.$level.'.msg');
//            })->sortable();
//
//
            $grid->column('user_tariff_code','用户等级')->display(function($level){
                return config('const_user.'.$level.'.msg');
             })->sortable();

             $grid->column('cash_status','提现状态')->display(function($cash_status){
                 return config('const_user.CASH_STATUS.'.$cash_status);
             })->sortable();

            $grid->column('account_name','实名')->sortable();

            $grid->column('last_login_time','最近登陆')->sortable();

            $grid->column('create_time','创建时间')->sortable();

            $grid->column('update_time','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
               // 设置created_at字段的范围查询
                $filter->like('user_name','用户名');
                $filter->like('login_name','手机号');
                $filter->equal('user_tariff_code','用户等级')->select(config('const_user.USER_LARAVEL'));
                $filter->equal('status','用户状态')->select(config('const_user.USER_STATUS'));
                $filter->between('create_time', '创建时间')->datetime();
                $filter->between('update_time', '更新时间')->datetime();
            });

           $grid->actions(function ($actions) {
               // 添加操作
               // 当前行的数据数组
               $actions->row;
               //获取当前行主键值
               $actions->getKey();
               //$actions->prepend();

               $actions->prepend("<a href='/admin/user/realname/{$this->getKey()}'>用户打回</a>");
               $actions->disableDelete();
               $actions->disableEdit();
           });

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });

           $grid->paginate(15);
        });

    }

    private function detail()
    {
        return Admin::form(CommUser::class,function(Form $form){

            $form->tab('基本信息',function(Form $form) {
                //列表常规内容
                $form->display('id','ID');
                $form->hidden('id','ID');

                $form->display('user_name','客户姓名');
                $form->display('login_name','手机号');

                //审批  testing...
                $form->tools(function (Form\Tools $tools) {
                    // $tools->disableBackButton();    // 去掉返回按钮
                    // $tools->disableListButton();   // 去掉跳转列表按钮
//                    // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//                    //$tools->add('<a class="btn btn-sm btn-danger" id="approved" ><i class="fa fa-trash"></i>&nbsp;&nbsp;审批</a>');
                    $tools->add('');
                    $url = "/admin/api/backUsers";
                    $icon = "fa fa-check";
                    $text = "用户打回";
                    $id = "examineadopt";
                    $tools->add(new ExtendButton($url,$icon,$text,$id));

                });
                $form->disableSubmit();//隐藏保存按钮
                $form->disableReset(); //去掉重置按钮
                //审批  testing...
            });

        });
    }
    
}