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
use App\Admin\Models\UpdateBrief;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class UpdateBriefController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('功能简介');
            $content->description('功能简介');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('功能简介信息修改');
            $content->description('功能简介信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('功能简介信息新增');
            $content->description('功能简介信息新增');
            
            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(UpdateBrief::class, function (Grid $grid){

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('update_title','更新标题')->sortable();
//            $grid->column('update_content','更新内容')->sortable();
            $grid->column('update_date','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('update_title','更新标题');
                $filter->like('update_content','更新内容');
                $filter->between('update_date', '更新时间')->datetime();
            });

            $grid->paginate(15);
        });
    }

    protected function form()
    {
        return Admin::form(UpdateBrief::class, function (Form $form) {
            $form->hidden('id');
            $form->text('update_title', '更新标题');
            $form->editor('update_content','更新内容');
            $form->datetime('update_date','更新时间');

            $form->saving(function (Form $form) {
                if (!$form->id) {
                    $form->id = ID();
                }
            });
        });
    }
}