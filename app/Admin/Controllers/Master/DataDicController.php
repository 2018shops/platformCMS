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
use App\Admin\Models\CommCodeMaster;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Log;


class DataDicController extends Controller
{
    use ModelForm;

    public function index() {
        Log::info('Showing user profile for user: ');
        return Admin::content(function (Content $content) {
            $content->header('数据字典');
            $content->description('数据字典');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('数据字典信息修改');
            $content->description('数据字典信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('数据字典信息新增');
            $content->description('数据字典信息新增');
            
            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(CommCodeMaster::class, function (Grid $grid){

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('code','CODE')->sortable();
            $grid->column('code_key','KEY')->sortable();
            $grid->column('property1','简述')->sortable();
            $grid->column('property2','属性2')->sortable();
            $grid->column('property3','属性3')->sortable();
            $grid->column('property4','属性4')->sortable();
            $grid->column('property5','属性5')->sortable();
//            $grid->column('property5','属性5')->sortable();
//            $grid->column('property6','属性6')->sortable();
//            $grid->column('property7','属性7')->sortable();
//            $grid->column('property8','属性8')->sortable();
//            $grid->column('property9','属性9')->sortable();
//            $grid->column('property10','属性10')->sortable();


            $grid->column('update_time','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('code','CODE');
                $filter->like('code_key','KEY');
                $filter->like('property1','简述');
            });

            $grid->paginate(15);
        });
    }

    public function form()
    {
        return Admin::form(CommCodeMaster::class, function (Form $form) {
            $form->hidden('id');
            $form->text('id','ID');
            $form->text('code', 'CODE');
            $form->text('code_key', 'KEY');
            $form->text('property1','简述');
            $form->text('property2','属性2');
            $form->text('property3','属性3');
            $form->text('property4','属性4');
            $form->text('property5','属性5');
            $form->saving(function (Form $form)  {
                if(!$form->id){
                    $form->id = ID();
                }
            });
        });
    }
}