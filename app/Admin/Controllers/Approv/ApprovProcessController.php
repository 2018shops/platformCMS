<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 10:01
 */
namespace App\Admin\Controllers\Approv;

use App\Admin\Models\ApprovProcess;
use App\Admin\Models\ApprovSetting;
use App\Admin\Models\AdminUsers;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ApprovProcessController  extends Controller{

use ModelForm;


    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('审批流程');
            $content->description('审批流程');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content) {
            $content->header('新增审批流程');
            $content->description('新增审批流程');
            $content->body($this->form());
        });
    }


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑审批流程');
            $content->description('编辑审批流程');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {
        return Admin::grid(ApprovProcess::class,function(Grid $grid){

            $grid->model()->orderBy('created_at', 'asc');
            $grid->column('id','ID');
            $grid->column('setting_id','设置ID')->display(function($id){
                $supplier = ApprovSetting::getId();
                return $supplier[$id];
            });
            $grid->column('step_name','步骤名称');
            $grid->column('module_name','模块名称');
            $grid->column('sequence','序列');

            $grid->column('agent_name','经办人')->display(function($id){
                $adminInfo = AdminUsers::getAdminUser();
                return $adminInfo[$id];
            });
            $grid->column('client_name','委托人');
            $grid->column('state','状态')
                ->display(function($state){
                    return config('approv.state.'.$state);
                })->sortable();
            $grid->column('next_step','下一步');


            $grid->column('updated_at','更新时间')->sortable();
            $grid->column('created_at','生成时间')->sortable();

        });
    }

    public function form()
    {
        return Admin::form(ApprovProcess::class,function(Form $form){

            $form->hidden('id','ID');

            $form->select('setting_id','设置ID')
                ->options(function(){
                    $supplier = ApprovSetting::getId();
                return $supplier;
            });

            $form->text('step_name','步骤名称');

            $form->text('module_name','模块名称');

            $form->select('sequence','序号')->options(
                [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                ]
            );

            $form->select('agent_name','经办人')
                ->options(function(){
                    $admin = AdminUsers::getAdminUser();
                return $admin;
            });

            $form->select('client_name','委托人')
                ->options(function(){
                    $admin = AdminUsers::getAdminUser();
                return $admin;
            });
            $form->select('state','状态')
                ->options(config('approv.state'));
            $form->text('next_step','下一步');


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