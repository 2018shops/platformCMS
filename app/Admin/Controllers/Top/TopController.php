<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 15:58
 */


namespace App\Admin\Controllers\Top;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\TopLine;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class TopController extends Controller{



    use ModelForm;

    public function index()
    {
        return Admin::content(function(Content $content){

           $content->header('头条');
           $content->description('头条');
           $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function( Content $content){

            $content->header('新增头条');
            $content->description('新增头条');
            $content->body($this->form());
        });
    }


    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑头条');
            $content->description('编辑头条');
            $content->body($this->form()->edit($id));
        });
    }

    public function grid()
    {
        return Admin::grid(TopLine::class,function(Grid $grid){
            $grid->model()->orderBy('update_time', 'desc');
            $grid->column('id','Id');
            $grid->column('con_id','关联ID')->sortable();
            $grid->column('title','标题');
            $grid->column('author','作者')->sortable();
            $grid->column('author_img','作者头像')->sortable();
            $grid->column('show_type','显示类型')
                ->display(function($show_type){
                    return config('top.show_type.'.$show_type);
                })->sortable();
            $grid->column('top_type','头条分类')
                ->display(function($top_type){
                    return config('top.top_type.'.$top_type);
                })->sortable();
            $grid->column('top_status','状态')
                ->display(function($top_status){
                    return config('top.top_status.'.$top_status);
                })->sortable();
            $grid->column('total_num','统计')->sortable();
            $grid->column('top_desc','分享描述');

            $grid->filter(function($filter){
                $filter->like('con_id','关联ID');
                $filter->like('title','标题');
                $filter->like('author','作者');
            });

        });
    }

    public function form()
    {

        return Admin::form(TopLine::class,function(Form $form){

            $form->display('id','ID');
            $form->hidden('id','ID');
            $form->text('con_id','关联ID');
            $form->text('title','标题')->rules('required');
            $form->text('author','作者')->rules('required');
            $form->image('author_img','作者头像');
            $form->text('author_desc','作者描述');
            $form->select('show_type','显示类型')
                ->options(config('top.show_type'))->rules('required');
            $form->image('attr1','图片一');
            $form->image('attr2','图片二');
            $form->image('attr3','图片三');


            $form->select('top_type','头条类型')
                ->options(config('top.top_type'));

            $form->select('top_status','状态')
                ->options(config('top.top_status'));
            $form->text('top_desc','摘要')->rules('required');
            $form->editor('content','内容')->rules('required');

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });

            $form->saved(function(Form $form){
            });



        });
    }
}