<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 9:17
 */

namespace App\Admin\Controllers\Test;



use App\Admin\Fields\Curl;
use App\Admin\Models\SendEmail;
use App\Http\Controllers\Controller;
use App\Admin\Contracts\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MailController extends Controller{

use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){

            $content->header("文章列表");
            $content->description('描述...');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header("文章新增");
            $content->description('文章描述...');
            $content->body($this->form());
        });
    }


    public function grid()
    {
        return Admin::grid(SendEmail::class,function(Grid $grid){
            $grid->column('id','Id');
            $grid->column('title','标题')->sortable();
            $grid->column('content','内容')->sortable();
            
        });
    }


    public function form()
    {
        return Admin::form(SendEmail::class,function(Form $form){
            $form->display('id','ID');
            $form->text('title','标题');
            $form->text('content','内容');

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
                $arr['title'] = $form->title;
                $arr['content'] = $form->content;
                $curl = new Curl();
                $curl->post_api($arr);
            });

            $form->saved(function(Form $form){
            });



        });
    }
}