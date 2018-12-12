<?php
namespace App\Admin\Controllers\Goods;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\CustomerButton;
use App\Admin\Models\GoodsClassify;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use App\Admin\Fields\ExcelExporter\ExportTaskRecord;
use Encore\Admin\Layout\Content;
use App\Admin\Fields\ExtendButton;
use App\Modules\WorkFlow\WorkFlow;


class GoodsClassifyController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('商品分类');
            $content->description('商品分类');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增商品分类');
            $content->description('新增商品分类');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑商品分类');
            $content->description('编辑商品分类');
            $content->body($this->form()->edit($id));
        });
    }
    public function grid()
    {
        return Admin::grid(GoodsClassify::class,function(Grid $grid) {
            $grid->exporter(new ExportTaskRecord());
            $grid->column('id','ID');
            $grid->column('name','菜单名称');
            $grid->column('pid','父ID');
            $grid->column('sort','排序');
            $grid->column('status','状态');
            $grid->column('img','图片')->display(function($img){
                if($img)
                    return "<img style=\"-webkit-user-select: none;\" height=\"56\" width=\"56\"  src=\"".$img."\"";
                else
                    return "";
             });
            $grid->column('update_at','时间');
        });
    }
}