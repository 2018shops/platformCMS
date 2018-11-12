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
use App\Admin\Models\CommNotice;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class HelpController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('帮助中心');
            $content->description('帮助中心');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帮助中心信息修改');
            $content->description('帮助中心信息修改');

            $content->body($this->form()->edit($id));
        });
    }

    

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('帮助中心新增');
            $content->description('帮助中心新增');
            
            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(CommNotice::class, function (Grid $grid){

            $grid->model()->orderBy('create_time', 'desc');
            $grid->model()->where('notice_type', '30');

            $grid->column('id','ID')->sortable();
            $grid->column('notice_type','公告类型')->display(function ($type){
                return config('const_notice.NOTICE_TYPE.'.$type);
            });
            $grid->column('notice_title','标题')->sortable();
            $grid->column('notice_desc','简介')->sortable();
            $grid->column('show_place','显示地方')->sortable();
            $grid->column('image_id','图片ID')->sortable();
            $grid->column('target_url','目标路径')->sortable();
            
            $states = [
                'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];
            $grid->column('valid_status','有效状态')->switch($states);  
            $grid->column('roling_status','滚动状态')->switch($states);

            $grid->column('close_status','关闭状态')->switch($states);
            $grid->column('update_time','更新时间')->sortable();

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
        return Admin::form(CommNotice::class, function (Form $form) {
            $form->hidden('id');
            
            $form->text('notice_title','标题');
            $form->textarea('notice_desc','简介')->rows(2);
            $form->editor('notice_content','内容');
            $form->hidden('notice_type','公告类型')->default(config('const_notice.HELP_TYPE.code'));
            $form->text('show_place','显示地方');
            $form->text('image_id','图片ID');
            $form->text('target_url','目标路径');

            $states = [
                'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];  
            
            $form->switch('roling_status','滚动状态')->states($states);
            $form->switch('valid_status','有效状态')->states($states);
            $form->switch('close_status','关闭状态')->states($states);
        });
    }
}