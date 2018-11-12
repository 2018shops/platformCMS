<?php

namespace App\Admin\Controllers\Record;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\MapLocation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MapLocationController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('定位统计');
            $content->description('定位统计');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(MapLocation::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('user.user_name','用户姓名');
            $grid->column('user.login_name','手机号');
            $grid->column('address','地址');
            $grid->column('province','省份');
            $grid->column('city','市');
            $grid->column('district','区');
            $grid->column('ip','IP');
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('user.user_name','用户名');
                $filter->like('user.login_name','手机号');
                $filter->like('address','地址');
                $filter->like('province','省份');
                $filter->like('city','市');
                $filter->like('district','区');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}