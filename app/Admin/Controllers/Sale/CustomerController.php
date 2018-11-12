<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/4/2
 * Time: 15:02
 */

namespace App\Admin\Controllers\Sale;

use Encore\Admin\Form;
use App\Admin\Contracts\Grid;
use App\Admin\Models\Customer;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Admin\Contracts\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;

class CustomerController extends Controller {
    //当前模块标识
    public $module = "customer"; 

    use ModelForm;

    public function index()
    {

        return Admin::content(function (Content $content){
            $content->header("客户管理");
            $content->description('客户信息列表');
            $content->body($this->grid());
        });

    }
    /**
     * 表格列表
     */
    public function grid()
    {
        Log::info("log ....");
        return Admin::grid(Customer::class,function(Grid $grid){

            $grid->column('id','ID')->sortable();
            $grid->column('customer_no','客户编号')->sortable();

            $grid->column('name','客户名称')->sortable()->display(function ($name) {
                return "<a href='/admin/sale/customer/{$this->getKey()}' class=''><b>$name</b></a>";
            });

            $grid->column('column_not_in_table','客户星级')->display(function () {
                return '※☆☆☆※';
            });

            $grid->column('mobile','手机')->sortable();

            $grid->column('email','邮箱')->sortable()->display(function ($email) {
                return "<span class='label label-info'>$email</span>";
            });

            $grid->leads('线索')->display(function($leads){
                //dd($leads);
                $count = count($leads);
                return "<a href='/admin/sale/leads?customer_id={$this->getKey()}'>
                        <span class='label label-warning'>{$count}</span>
                        </a> 
                    ";
            });
            $grid->column('sysuser.name','添加者')->sortable();
            $grid->column('created_at','添加时间')->sortable();
            //查询条件也能放:
            //$grid->model()->where('id', '=', 1);
            $grid->model()->orderby('updated_at', 'desc');
            $grid->actions(function ($actions) {
                // append一个操作
                //$actions->append("<a href='/admin/sale/customer/{$this->getKey()}'><i class='fa fa-eye'>审批</i></a>");
                // prepend一个操作
                $actions->prepend("<a href='/admin/sale/customer/{$this->getKey()}'><i class='fa fa-eye'>详情</i></a>");
            });
            //数据筛选
            $grid->filter(function($filter){
                $filter->like('name','姓名');
            });
        });
    }
    
    /**
     * 创建客户信息
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('客户信息');
            $content->description('添加新增客户');
            $content->body($this->form());
        });
    }

    /**
     * 显示详情
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('客户信息');
            $content->description('客户详情');
            $content->body($this->detail()->view($id));
        });
    }

    /**
     * 编辑客户信息
     */
    public function edit($id)
    {
        Log::info("edit....".$id);
        checkApproveEdit($id,$this->module);
        return Admin::content(function (Content $content) use ($id) {
            $content->header('客户信息');
            $content->description('编辑更新客户资料');
            $content->body($this->form()->edit($id));
        });
    }
    /**
     * 表单信息
     */
    public function form()
    {
        return Admin::form(Customer::class,function(Form $form){

            $form->hidden('id','ID');
            $form->hidden('customer_no','客户编号');
            $form->hidden('created_by')->default(Admin::user()->getAuthIdentifier());
            $form->hidden('updated_by')->default(Admin::user()->getAuthIdentifier());
            $form->text('name','客户姓名');
            $form->text('mobile','手机号码')->placeholder('手机号码必须准确输入');
            $form->text('email','Email')->placeholder('请输入正确的邮箱');
            $form->editor('desr','客户备注');
            // $form->date('mobile','手机号码')
            //     ->default(date('Y-m-d'));
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
            $form->saving(function (Form $form)  {
                if(!$form->id){
                    Log::info("ID()....".ID());
                    $form->id = ID();
                }
                //$form->mobile = [];
                // $error = new MessageBag([
                //     'title'   => 'title...',
                //     'message' => 'message....',
                // ]);     
                //return back()->with(compact('error'));
            });
        });
    }
    /**
     * 显示表单信息
     */
    private function detail()
    {
        return Admin::form(Customer::class,function(Form $form){
            //列表常规内容
            $form->display('id','ID');
            $form->hidden('customer_no');
            $form->display('name','客户姓名');
            $form->display('mobile','手机号码');
            $form->display('email','Email');
            $form->display('desr','客户备注');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
            //列表常规内容

            //审批  testing...
            $form->tools(function (Form\Tools $tools) {
                //$tools->disableBackButton();   // 去掉返回按钮
                //$tools->disableListButton();   // 去掉跳转列表按钮
                // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
                //$tools->add('<a class="btn btn-sm btn-danger" id="approved" ><i class="fa fa-trash"></i>&nbsp;&nbsp;审批</a>');
                $tools->add(approvedBtn ());//审批
                $tools->add(rejectBtn ());//驳回
            });
            $form->disableSubmit();//隐藏保存按钮
            $form->disableReset(); //去掉重置按钮
            //审批  testing...
        });
    }

}