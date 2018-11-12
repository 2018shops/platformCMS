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
use App\Admin\Models\CommBankDb;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class BankController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('银行列表');
            $content->description('银行列表');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('银行信息修改');
            $content->description('银行信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('银行信息新增');
            $content->description('银行信息新增');
            
            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(CommBankDb::class, function (Grid $grid){
            
            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->disableActions();

            $grid->column('id','ID')->sortable();
            $grid->column('code','支付系统行号')->sortable();
            $grid->column('name','名称')->sortable();
            $grid->column('head_code','总行代码')->sortable();
            $grid->column('head_name','总行')->sortable();
            $grid->column('head_eng','总行英文')->sortable();
            $grid->column('state_code','省代码')->sortable();
            $grid->column('state_name','省')->sortable();
            $grid->column('city_code','市代码')->sortable();
            $grid->column('city_name','市')->sortable();
            $grid->column('tag','标签')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('notice_type','公告类型');
                $filter->like('notice_title','标题');
                $filter->between('update_time', '更新时间')->datetime();
            });

            $grid->paginate(15);
        });
    }

    protected function form()
    {
        return Admin::form(CommBankDb::class, function (Form $form) {
            $form->hidden('id');
            $form->text('code','支付系统行号');
            $form->text('name','名称');
            $form->text('head_code','总行代码');
            $form->text('head_name','总行');
            $form->text('head_eng','总行英文');
            $form->text('state_code','省代码');
            $form->text('state_name','省');
            $form->text('city_code','市代码');
            $form->text('city_name','市');
            $form->text('tag','标签');

        });
    }
}