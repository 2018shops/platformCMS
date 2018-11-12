<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/8
 * Time: 13:54
 */

namespace App\Admin\Controllers\Team;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExtendButton;
use App\Admin\Models\TranTransOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;


class InviteCodeExamineController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('邀请码提交审核');
            $content->description('账户邀请码提交审核');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(TranTransOrder::class,function(Grid $grid){
            $grid->model()->where('type', '10');
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id','ID')->sortable()->display(function ($id){
                return "<a href='/admin/user/invite_code_examine/{$this->getKey()}' class=''><b>$id</b></a>";
            });
            $grid->column('invite_code','邀请码');
            $grid->column('trans_time','交易时间')->sortable();
            $grid->column('user_id','用户编号');
            $grid->column('user.user_name','用户姓名')->sortable();
            $grid->column('user.level_name','用户等级')
                ->display(function($level){
                    return config('const_user.'.$level.'.msg');
                });
            $grid->column('business_code','业务类型')
                ->display(function ($business_code){
                    $msg = $business_code . '->' . config('interface.DICT.'.$business_code .'.msg');
                    return $msg;
                });
            $grid->column('user.login_name','手机号码');
            $grid->column('code.level_name','邀请码类型')
                ->display(function($level_name){
                    return config('exam.Invite.level_name.'.$level_name);
                });
            $grid->column('code.amount','邀请码价格');
            $grid->column('status','交易状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            $grid->column('update_time','更新时间')->sortable();

            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('id','ID');
                $filter->like('business_code','业务类型');
                $filter->like('user_name','用户名');
                $filter->like('user.login_name','手机号');
                $filter->like('user_id','用户编号');
                $filter->like('status','交易状态')->select(config('const_trans.summary_status'));
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();

        });
    }

    public function form()
    {
        return Admin::form(TranTransOrder::class,function(){

        });
    }
    /**
     * 显示详情
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('邀请码提交审核');
            $content->description('邀请码提交审核');
            $content->body($this->detail()->view($id));
        });
    }

    private function detail()
    {
        return Admin::form(TranTransOrder::class,function(Form $form){

            $form->tab('推荐关系',function(Form $form){
                return $form->uprecommend('user_id','上级推荐');

            });
            $form->tab('基本信息',function(Form $form){
                //列表常规内容
                $form->display('id','ID');
                $form->hidden('id','ID');

                $form->display('trans_amt','交易金额');
                $form->display('user_id','用户编号');
                $form->display('user.user_name','用户名');
                $form->display('business_code','业务类型')
                    ->with(function ($business_code){
                        $msg = $business_code . '->' . config('interface.DICT.'.$business_code .'.msg');
                        return $msg;
                    });
                $form->display('status','交易状态')
                    ->with(function ($status){
                        return config('const_trans.summary_status.'.$status);
                    });
                $form->display('trans_time','交易时间');


                //审批  testing...
                $form->tools(function (Form\Tools $tools) {
                    $tools->add('');
                    $url = "/admin/workflow.inviteUpgradeAdopt";
                    $icon = "fa fa-check";
                    $text = "审核通过";
                    $id = "examineadopt";
                    $tools->add(new ExtendButton($url,$icon,$text,$id));

                    $url = "/admin/workflow.upgradereject";
                    $icon = "fa fa-times";
                    $text = "驳回";
                    $id = "examinereject";
                    $class = "btn btn-danger pull-left";
                    $tools->add(new ExtendButton($url,$icon,$text,$id,$class));
                });
                $form->disableSubmit();//隐藏保存按钮
                $form->disableReset(); //去掉重置按钮
            });


        });
    }
}