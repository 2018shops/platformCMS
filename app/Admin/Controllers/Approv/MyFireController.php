<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 14:30
 */
namespace App\Admin\Controllers\Approv;


use App\Admin\Models\ApprovProcess;
use App\Admin\Models\ApprovRecord;
use App\Admin\Controllers\Api\Approv;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MyFireController extends Controller{


    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('我发起的');
            $content->description('我发起的');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        
        return Admin::grid(ApprovRecord::class,function(Grid $grid){
            $grid->model()->where([
                'approver' => Admin::user()->id,
                'approv_state' => -1
            ]);

            $grid->column('id',"ID");
            $grid->column('module_name',"模块名称");

            $grid->column('relation_id','审批详情')->sortable()->display(function ($relation_id) {
                return Approv::approvDetails($relation_id);
            });

            $grid->column('approvsetting.approv_name','审批模块名称');
            $grid->column('process.step_name','审批流程名称')->display(function($name){
                return empty($name) ? '提交审批' : $name;
            });
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