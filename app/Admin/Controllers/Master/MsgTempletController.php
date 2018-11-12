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
use App\Admin\Models\CommPushTemplet;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class MsgTempletController extends Controller
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
        return Admin::grid(CommPushTemplet::class, function (Grid $grid){

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('templet_id','模板ID')->sortable();
            $grid->column('templet_name','模板名称')->sortable();
            $grid->column('business_code','推送业务编号')->sortable();
            $grid->column('title','标题')->sortable();
            $grid->column('content','内容')->display(function($text) {
                return $text;
                return substr($text, 0,70).'...';
            });
            $grid->column('image','图片');
            $grid->column('url','链接');
            $grid->column('status','状态')->sortable();
            $grid->column('push_type','推送类型')->sortable();
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
        return Admin::form(CommPushTemplet::class, function (Form $form) {
            $form->hidden('id');
            $form->text('templet_id','模板ID');
            $form->text('templet_name','模板名称');
            $form->text('business_code','推送业务编号');
            $form->text('title','标题');
            $form->textarea('content','内容')->rows(2);
            $form->image('image','图片');
            $form->text('url','链接');

            $states = [
                'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];  

            $form->switch('status','状态')->states($states);
            $form->text('push_type','推送类型');
            $form->text('status','状态');
        });
    }
}