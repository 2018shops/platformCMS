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
use App\Admin\Models\CommPushRecord;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class MsgController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('消息列表');
            $content->description('消息列表');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('消息列表信息修改');
            $content->description('消息列表信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('消息列表信息新增');
            $content->description('消息列表信息新增');
            
            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(CommPushRecord::class, function (Grid $grid){

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('process_id_from','编号FROM')->sortable();
            $grid->column('process_id_to','编号TO')->sortable();
            $grid->column('business_code','模板Id')->sortable();
            $grid->column('title','标题')->sortable();
            $grid->column('content','内容')->display(function($text) {
                
                return substr($text, 0,70).'...';
            });
            $grid->column('type','客户端类型')->sortable();
            $grid->column('url','链接');
            $grid->column('status','状态')->sortable();
            $grid->column('update_time','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('title','标题');
                $filter->like('content','内容');
                $filter->equal('type','客户端类型')->select(config('const_user.USER_LARAVEL'));
            });

            $grid->paginate(15);
        });
    }

    protected function form()
    {
        return Admin::form(CommPushRecord::class, function (Form $form) {
            $form->hidden('id');
            $form->text('process_id_from','编号FROM');
            $form->text('process_id_to','编号TO');
            $form->text('business_code','模板Id');
            $form->text('title','标题');
            $form->textarea('content','更新内容')->rows(10);
            $form->text('type','客户端类型');
            $form->text('url','链接');
        });
    }
}