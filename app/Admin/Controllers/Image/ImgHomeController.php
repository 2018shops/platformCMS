<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 15:58
 */
namespace App\Admin\Controllers\Image;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\ImgHome;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ImgHomeController extends Controller{

    use ModelForm;

    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('广告');
            $content->description('广告');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content){
            $content->header('新建广告');
            $content->description('新建广告');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑广告');
            $content->description('广告');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {
        return Admin::grid(ImgHome::class,function(Grid $grid){
            $grid->column('id','Id');
            $grid->column('banner','图片地址');
            $grid->column('on_status','状态')->display(function($type){
                return config('meeting.banner_status.'.$type);
            })->sortable();
            $grid->column('jump_url','跳转地址');
            $grid->column('type','广告类型')->display(function($type){
                return config('meeting.ad_type.'.$type);
            })->sortable();
        });
    }

    public function form()
    {
        return Admin::form(ImgHome::class,function(Form $form){
            $form->display('id','Id');
            $form->image('banner','图片地址');

            $form->select('on_status', '状态')->options(
                config('meeting.banner_status')
            )->rules('required');

            $form->text('jump_url','跳转地址');
            $form->select('type', '状态')->options(
                config('meeting.ad_type')
            )->rules('required');

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