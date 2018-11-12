<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 10:01
 */
namespace App\Admin\Controllers\Approv;


use App\Admin\Models\ApprovRecord;
use App\Admin\Models\CommUser;
use App\Admin\Models\Customer;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ApprovRecordController  extends Controller{

use ModelForm;


    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('审批记录');
            $content->description('审批记录');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content) {
            $content->header('新增审批记录');
            $content->description('新增审批记录');
            $content->body($this->form());
        });
    }


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑审批记录');
            $content->description('编辑审批记录');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {
        return Admin::grid(ApprovRecord::class,function(Grid $grid){
            $grid->model()->orderBy('created_at', 'desc');
            $grid->column('id','ID');
            
            $grid->column('module_name','审批模块名称');

            // dd($grid->module_name);

            // $grid->column('customer.name','审批详情'); //发起人

            $grid->column('relation_id','审批详情')->sortable()->display(function ($relation_id) {

                $ret = ApprovRecord::getModuleName($relation_id);
                
                switch($ret->module_name){
                    case 'customer' : 
                        $customerInfo = Customer::getCustomerName($relation_id);
                        $name = '';
                        if(isset($customerInfo->name)){
                            $name = $customerInfo->name;
                        }
                        return "<a href='/admin/sale/customer/{$relation_id}' class=''><b>$name</b></a>";
                    case 'userupgrade':
                        $userInfo = CommUser::getUserName($relation_id);
                        $name = '';
                        if(isset($userInfo->user_name)){
                            $name = $userInfo->user_name;
                        }
                        return "<a href='/admin/user/users/{$relation_id}' class=''><b>$name</b></a>";
                }

                return "<a href='/admin/user/users/{$relation_id}' class=''><b>$relation_id</b></a>";
            });


            $grid->column('approvsetting.approv_name','审批模块名称');
            $grid->column('process.step_name','流程名称');
            
            $grid->column('admin.name','经办人');
            
            $grid->column('approv_state','审批状态')->display(function ($type) {
                return config('approv.approv_state.'.$type);
            });

            $grid->column('approv_brief','审批描述');

            $grid->column('updated_at','更新时间')->sortable();
            $grid->column('created_at','生成时间')->sortable();

        });
    }

    public function form()
    {
        return Admin::form(ApprovRecord::class,function(Form $form){

            $form->hidden('id','ID');
            $form->text('module_name','模块名称');
            $form->text('relation_id','关联ID');
            $form->text('setting_id','审批设置ID');
            $form->text('process_id','流程ID');
            $form->text('approver','审批人');
            $form->text('approv_state','审批状态');
            $form->text('approv_brief','审批描述');

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });

            $form->saved(function(Form $form){
            });



        });
    }
}