<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 15:43
 */
namespace App\Admin\Controllers\Finance;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctBookingPolicy;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;


class AcctPolicyController extends Controller{

    use ModelForm;

    public function index()
    {
        return Admin::content(function( Content $content){

            $content->header('记账码检测中间件');
            $content->description('记账码检测中间件');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function( Content $content){

            $content->header('新增记账检测');
            $content->description('记账检测列表');
            $content->body($this->form());
        });
}


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑记账检测');
            $content->description('编辑记账检测');
            $content->body($this->form()->edit($id));
        });
    }

    public function grid()
    {

        return Admin::grid(AcctBookingPolicy::class,function(Grid $grid){
            $grid->column('id',"ID");
            $grid->column('request_code','记账请求码')->sortable();
            $grid->column('policy_name','检测中间件名称')->sortable();
            $grid->column('policy_bean','检测中间件BEAN')->sortable();
            //$grid->column('policy_value','策略值')->sortable();
            //$grid->column('response_code','记账返回码')->sortable();
            $grid->column('sort','排序')->sortable();
            $grid->column('remark','摘要')->sortable();

            $grid->filter(function($filter){
                $filter->like('policy_name','检测中间件名称');
                $filter->like('request_code','记账请求码');
            });

            $grid->column('update_time','更新时间')->sortable();
            $grid->column('create_time','生成时间')->sortable();
        });
    }

    public function form()
    {
        return Admin::form(AcctBookingPolicy::class,function(Form $form){

            $form->display('id','ID');

            $form->text('request_code','记账请求码');
            $form->text('policy_name','检测中间件名称');
            $form->text('policy_bean','检测中间件BEAN');
            //$form->text('policy_value','策略值');
            //$form->text('response_code','记账返回码');
            $form->select('sort','排序')->options(['请选择','1','2','3','4','5','6','7','8','9']);
            $form->text('remark','摘要');

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