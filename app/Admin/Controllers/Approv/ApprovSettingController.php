<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 10:01
 */
namespace App\Admin\Controllers\Approv;


use App\Admin\Models\ApprovRecord;
use App\Admin\Models\ApprovSetting;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ApprovSettingController  extends Controller{

use ModelForm;


    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('审批设置');
            $content->description('审批设置');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content) {
            $content->header('新增审批设置');
            $content->description('新增审批设置');
            $content->body($this->form());
        });
    }


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑审批设置');
            $content->description('编辑审批设置');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {
        return Admin::grid(ApprovSetting::class,function(Grid $grid){

            $grid->column('id','ID');
            $grid->column('module_name','模块名称');
            $grid->column('approv_name','审批名称');
            $grid->column('opening_state','是否激活')
                ->display(function($opening_state){
                    return config('approv.opening_state.'.$opening_state);
                })->sortable();

            $grid->column('updated_at','更新时间')->sortable();
            $grid->column('created_at','生成时间')->sortable();

        });
    }

    public function form()
    {
        return Admin::form(ApprovSetting::class,function(Form $form){

            $form->hidden('id','ID');
            $form->text('module_name','模块名称');
            $form->text('approv_name','审批名称');
            $form->select('opening_state','是否激活')
                ->options(config('approv.opening_state'));

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