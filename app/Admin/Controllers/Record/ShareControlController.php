<?php

namespace App\Admin\Controllers\Record;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\ShareControl;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ShareControlController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('分享统计');
            $content->description('分享统计');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(ShareControl::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('ip','Ip地址');
            $grid->column('share_id','分享ID');
            $grid->column('open_id','微信用户标识');
            $grid->column('user_id','关联用户');
            $grid->column('title','标题');
            $grid->column('type','类型')->sortable();
            $grid->column('desc','描述');

            $grid->column('create_time','生成时间')->sortable();
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('share_id','分享ID');
                $filter->like('open_id','微信用户标识');
                $filter->like('user_id','关联用户');
                $filter->like('title','标题');
                $filter->like('type','类型');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}