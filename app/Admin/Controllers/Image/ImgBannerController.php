<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 15:58
 */
namespace App\Admin\Controllers\Image;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\ImgBanner;
use App\Admin\Models\TopLine;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ImgBannerController extends Controller{

    use ModelForm;

    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('首页banner图');
            $content->description('首页banner图,首页banner750X308');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content){
            $content->header('新建首页banner图');
            $content->description('新建首页banner图(首页banner750X308)');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑首页banner图');
            $content->description('编辑首页banner图(首页banner750X308)');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {

        return Admin::grid(ImgBanner::class,function(Grid $grid){
            $grid->column('id','Id');
            $grid->column('title','标题')->sortable();
            $grid->column('desc','描述')->sortable();
            $grid->column('img_url','图片地址')->sortable();
            $grid->column('relation_type','关联类型')->sortable();
            $grid->column('relation_page','关联页面')->sortable();
            $grid->column('status','状态')->display(function($type){
                return config('meeting.banner_status.'.$type);
            })->sortable();


            $grid->filter(function($filter){
                $filter->like('meeting_name','咖啡店名称');
            });
        });
    }

    public function form()
    {

            return Admin::form(ImgBanner::class,function(Form $form){
            $form->display('id','ID');
            $form->text('title','标题');
            $form->text('desc','描述');
            $form->text('relation_page','关联页面');
            $form->text('relation_type','关联类型');
            $form->image('img_url','图片地址');
                $form->select('status', '状态')->options(
                    config('meeting.banner_status')
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