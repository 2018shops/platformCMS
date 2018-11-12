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

class UserController extends Controller {

    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('用户管理');
            $content->description('用户列表');

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

            $content->header('信息修改');
            $content->description('用户信息修改');

            $content->body($this->form()->edit($id));
        });
    }

     /**
     * 显示详情
     */
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

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('user_id','ID')->sortable();

            $grid->column('user_name','用户名')->sortable()->display(function ($user_name) {
                return "<a href='/admin/user/users/{$this->getKey()}' class=''><b>$user_name</b></a>";
            });
           $grid->column('account_name','实名')->sortable();
            $grid->column('login_name','手机号')->sortable();

            $grid->column('level_name','资费|等级')->display(function ($level_name) {
               return "<span class='label label-primary'>{$level_name}</span><br/>".
                   "<span class='label label-success'>".config('const_user.USER_LARAVEL.'.$this->user_tariff_code)."</span>";
            });

//            $grid->column('user_tariff_code','用户等级')->display(function($level){
//               return config('const_user.USER_LARAVEL.'.$level);
//            })->sortable();

            $grid->column('cash_status','提现状态')->display(function($cash_status){
                return config('const_user.CASH_STATUS.'.$cash_status);
             })->sortable();

            $grid->column('status','用户状态')->display(function($status){
                return config('const_user.USER_STATUS.'.$status);
             })->sortable(); 


            $grid->column('referral_code','推荐码')->sortable();
            $grid->column('headimgurl','用户头像')->display(function($headimgurl){
               if($headimgurl)
                   return "<img style=\"-webkit-user-select: none;\" height=\"56\" width=\"56\"  src=\"".$headimgurl."\"";
               else
                   return "";
            });
            $grid->column('wx.city','城市')->sortable();
            $grid->column('last_login_time','最近登陆')->display(function($last_login_time){
               return "<span class='label label-default'>登录:".$last_login_time."</span><br/>".
                   "<span class='label label-success'>注册:".$this->create_time."</span><br/>".
                   "<span class='label label-info'>更新:".$this->update_time."</span><br/>";
            })->sortable();
            //$grid->column('last_login_time','最近登陆')->sortable();
            //$grid->column('create_time','创建时间')->sortable();
            //$grid->column('update_time','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
               // 设置created_at字段的范围查询
                $filter->like('user_name','用户名');
                $filter->like('login_name','手机号');
                $filter->like('referral_code','推荐码');
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
//               $actions->disableDelete();
//               $actions->disableEdit();
           });

           $grid->paginate(15);
        });

    }

    protected function form()
    {
        return Admin::form(CommUser::class, function (Form $form) {
            $form->hidden('id');
            $form->display('user_id', 'ID');
            $form->text('user_name', '用户名')->rules('required');
            $form->display('login_name', '手机号')->rules('required');

            $form->display('user_tariff_code', '	用户资费');

            $form->display('user_tariff_code', '用户等级')->with(function ($type){
                return config('const_user.'.$type.'.msg');
            });

            $form->display('last_login_time','最近登陆');

            $form->select('status', '用户状态')->options(
                config('const_user.USER_STATUS')
            )->rules('required');

            $form->select('cash_status','提现状态')->options(function($status){
                return  config('const_user.CASH_STATUS');
            })->rules('required');

            $form->select('new_level', '升级等级')->options(function ($type){
                return config('const_user.USER_LARAVEL');
            });

            $form->text('trans_amt', '交易金额');

        });
    }

    private function detail()
    {
        return Admin::form(CommUser::class,function(Form $form){

            $form->tab('上级推荐',function(Form $form){
                return $form->uprecommend('user_id','上级推荐');
            });

            $form->tab('推荐关系',function(Form $form){
                return $form->three_uprecommend('user_id','推荐关系');
            });


            $form->tab('基本信息',function(Form $form) {
                //列表常规内容
                $form->display('id','ID');
                $form->hidden('id','ID');
                $form->hidden('module')->default('userupgrade');
                $form->hidden('approv_state','审批状态');

                $form->display('user_name','客户姓名');
                $form->display('login_name','手机号码');
                $form->display('wx.unionid','unionid');
                $form->display('wx.openid','openid');
                $form->display('wx.nickname','微信昵称');
                $form->display('wx.city','城市');
//            $form->display('wx.headimgurl','微信头像');
                $form->display('wx.headimgurl','微信头像')->with(function ($src){
                    return "<img src='{$src}'>";
                });


                $form->display('level_name', '当前等级')->with(function ($level_name){
                    return config('const_user.USER_LARAVEL.'.$level_name);
                });

                $form->display('new_level', '将要升级的等级')->with(function ($level_name){
                    return config('const_user.USER_LARAVEL.'.$level_name);
                });

                // $form->select('new_level','将要升级的等级')
                //     ->options(config('const_user.USER_LARAVEL'));

                $form->display('trans_amt', '交易金额');
                //列表常规内容

                //审批  testing...
                $form->tools(function (Form\Tools $tools) {
                    // $tools->disableBackButton();       // 去掉返回按钮
                    // $tools->disableListButton();   // 去掉跳转列表按钮
//                    // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//                    //$tools->add('<a class="btn btn-sm btn-danger" id="approved" ><i class="fa fa-trash"></i>&nbsp;&nbsp;审批</a>');
                    $tools->add('');
                    $url = "/admin/workflow.upgrade";
                    $icon = "fa fa-check";
                    $text = "提交审核";
                    $id = "examineadopt";
                    $tools->add(new ExtendButton($url,$icon,$text,$id));

                    $url = "/admin/workflow.upgradewithdraw";
                    $icon = "fa fa-times";
                    $text = "撤回";
                    $id = "withdraw";
                    $class = "btn btn-danger pull-left";
                    $tools->add(new ExtendButton($url,$icon,$text,$id,$class));
                });
                $form->disableSubmit();//隐藏保存按钮
                $form->disableReset(); //去掉重置按钮
                //审批  testing...
            });

        });
    }
    
}