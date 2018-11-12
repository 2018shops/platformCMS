<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/25
 * Time: 11:20
 */

namespace App\Admin\Controllers\Master;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\CommSms;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class SMSController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('短信记录');
            $content->description('短信记录');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('短信记录信息');
            $content->description('短信记录信息');

            $content->body($this->form()->edit($id));
        });
    }

    public function grid()
    {
        return Admin::grid(CommSms::class, function (Grid $grid){

            $grid->disableCreateButton();
            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('mobile','手机号')->sortable();
            $grid->column('captcha','验证码')->sortable();
            $grid->column('business_code','模版')->sortable();
            $grid->column('create_time','创建时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('mobile','手机号');
            });

            $grid->paginate(15);
        });
    }

    protected function form()
    {
        return Admin::form(CommSms::class, function (Form $form) {
            $form->hidden('id');
            $form->display('mobile', '手机号');
            $form->display('captcha', '验证码');
            $form->display('business_code','模版');
            $form->display('create_time','创建时间');
        });
    }
}