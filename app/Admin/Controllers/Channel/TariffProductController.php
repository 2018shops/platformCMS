<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctTariffProduct;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class TariffProductController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('资费产品');
            $content->description('资费产品');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增资费产品');
            $content->description('新增资费产品');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑资费产品');
            $content->description('编辑资费产品');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(AcctTariffProduct::class, function (Form $form){
            $form->display('id', 'ID');
            $form->hidden('create_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->hidden('update_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->text('tariff_code', '资费产品编号');
            $form->text('tariff_name', '资费产品名称');
            $form->text('remarks', '备注');

            $states = [
                'on' => ['value' => 1, 'text' => '启用', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],

            ];
            $form->switch('status', '状态')->states($states);

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });
            $form->saved(function (Form $form) {
            });
        });
    }
    public function grid()
    {
        return Admin::grid(AcctTariffProduct::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('tariff_code','资费产品编号')->sortable();
            $grid->column('tariff_name','资费产品名称')->sortable();
            $grid->column('status','状态')->sortable();


            $grid->column('remarks','备注')->sortable();
            $grid->column('create_by','创建者')->sortable();
            $grid->column('update_by','更新者');

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('status','状态');
            });

            $grid->column('create_time','生成时间')->sortable();
            $grid->column('update_time','更新时间')->sortable();
        });
    }
}