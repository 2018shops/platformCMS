<?php

namespace App\Admin\Controllers\Record;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\CommSms;
use App\Admin\Models\MapLocation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class SmsRecordController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('短信记录');
            $content->description('短信记录');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(CommSms::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('mobile','手机号')->sortable();
            $grid->column('business_code','业务模版')->sortable();
            $grid->column('captcha','验证码');
            $grid->column('search_id','检索ID')->sortable();
            $grid->column('response','状态');
            $grid->column('create_time','创建时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('mobile','手机号');
                $filter->like('business_code','业务模版');
                $filter->like('search_id','检索ID');
            });
            // 禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}