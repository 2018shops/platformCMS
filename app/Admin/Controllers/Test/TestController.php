<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/3
 * Time: 11:15
 */
namespace App\Admin\Controllers\Test;

use App\Admin\Contracts\Grid;
use App\Admin\Models\BuyOrder;
use App\Admin\Models\Product;
use App\Admin\Models\Store;
use App\Admin\Models\StoreStock;
use App\Admin\Models\Supplier;
use App\Admin\Models\Testuser;
use App\Http\Controllers\Controller;
use App\Admin\Contracts\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Log;

class TestController extends Controller{

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
        return Admin::content(function (Content $content){
            $content->header("文章新增");
            $content->description('文章描述...');
            $content->body($this->form());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑文章');
            $content->description('description');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {

        return Admin::grid(TestUser::class, function(Grid $grid){
            $grid->column('id',"ID");
            $grid->column('title','标题')->sortable();
//            $grid->column('sex','性别')
//                ->display(function($sex){
//                    return config('selection.sex.'.$sex);
//                })->sortable();
            $grid->column('updated_at','更新时间')->sortable();
            $grid->column('created_at','生成时间')->sortable();
            $grid->filter(function($filter){
                $filter->like('name','标题');
            });
        });
    }

    public function form()
    {
        return Admin::form(TestUser::class,function(Form $form){

            $form->display('id','ID');

            $form->text('title','标题');
//            $form->editor('content','内容');

            $form->saving(function (Form $form) {
                $form->id = ID();
            });

            $form->saved(function(Form $form){
            });



        });
    }
}