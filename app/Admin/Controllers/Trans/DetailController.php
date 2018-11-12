<?php
namespace App\Admin\Controllers\Trans;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExtendButton;
use App\Admin\Models\CommUserInfo;
use App\Admin\Models\TranTransOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class DetailController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('pms用户升级流水');
            $content->description('pms用户升级流水');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(TranTransOrder::class,function(Grid $grid) {
            $grid->model()->where('type', '20')->orderBy('create_time', 'desc');
            $grid->column('id','明细流水ID')->sortable()->display(function ($user_name) {
                return "<a href='/admin/trans/detail/{$this->getKey()}' class=''><b>$user_name</b></a>";
            });

            $grid->column('business_code','业务类型')
                ->display(function ($business_code){
                    $msg = $business_code . '->' . config('interface.DICT.'.$business_code .'.msg');
                    return $msg;
                });
            $grid->column('trans_amt','交易金额')->display(function(){
                return "<span class='label label-success'>".$this->trans_amt."</span>";
            })->sortable();
            $grid->column('trans_time','交易时间')->sortable();
            $grid->column('user_id','用户编号');
            $grid->column('user.user_name','用户名');
            $grid->column('user.login_name','手机号');

            $grid->column('status','交易状态')
                ->display(function ($status){
                    return config('const_trans.summary_status.'.$status);
                });
            $grid->column('channel_id','通道ID');
            $grid->column('channel_merc_id','通道商户编号');
            $grid->column('agent_id','代理商编号');
            $grid->column('update_time','更新时间')->sortable();
            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('id','明细流水ID');
                $filter->like('business_code','业务类型');
                $filter->like('user_name','用户名');
                $filter->like('user.login_name','手机号');
                $filter->like('user_id','用户编号');
                $filter->like('status','交易状态')->select(config('const_trans.summary_status'));
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();

            $model = $grid->getQuerylModel();
            $grid->footer(function ($footer) use ($model){
                $footer->td("");
                $footer->colspan(1);
                $footer->td("<span class='label label-primary'>合计</span>");
                $footer->td("<span class='label label-danger'>".$model->sum('trans_amt')."</span>");
//                $footer->td("<span class='label label-danger'>".$model->sum('receive_amt')."</span>");

            });
        });
    }

    /**
     * 显示详情
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('pms用户升级流水');
            $content->description('pms用户升级流水');
            $content->body($this->detail()->view($id));
        });
    }

    private function detail()
    {
        return Admin::form(TranTransOrder::class,function(Form $form){

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
//                    $tools->add('');
//                    $url = "/admin/workflow.sendInvCode";
//                    $icon = "fa fa-check";
//                    $text = "用户发放邀请码";
//                    $id = "sendInvCode";
//                    $tools->add(new ExtendButton($url,$icon,$text,$id));

                    $tools->add('');
                    $url = "/admin/workflow.upgradeadopt";
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
                //审批  testing...
            });

        });
    }
}