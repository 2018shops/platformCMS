<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 9:35
 */

namespace App\Admin\Controllers\Approv;

use App\Admin\Models\ApprovRecord;
use App\Admin\Models\CommUser;
use App\Admin\Models\Customer;
use App\Admin\Controllers\Api\Approv;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;



class ToApprovController extends Controller{

    use ModelForm;


    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('待我审批');
            $content->description('待我审批');
            $content->description('待我审批');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(ApprovRecord::class,function(Grid $grid){
            $grid->model()->where([
                'approver' => Admin::user()->id,
                'approv_state' => 0
            ]);

            $grid->column('id','ID');
            $grid->column('module_name','审批模块名称');

            $grid->column('relation_id','审批详情')->sortable()->display(function ($relation_id) {
                return Approv::approvDetails($relation_id);
            });

            $grid->column('approvsetting.approv_name','审批流程名称');
            $grid->column('process.step_name','流程名称');
            $grid->column('admin.name','经办人');
            
            $grid->column('approv_state','审批状态')->display(function ($type) {
                return config('approv.approv_state.'.$type);
            });
            $grid->column('approv_brief',"简述");

            $grid->column('updated_at','更新时间')->sortable();
            $grid->column('created_at','生成时间')->sortable();
        });
    }


}