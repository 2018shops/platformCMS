<?php

namespace App\Admin\Controllers\Record;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AppLog;
use App\Admin\Models\MapLocation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class OperationLogController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('操作日志');
            $content->description('操作日志');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(AppLog::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('log_id',"编号")->sortable();
            $grid->column('content','操作明细');
            $grid->column('create_time','操作时间')->sortable();


            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('log_id',"编号");
                $filter->like('content','操作明细');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}