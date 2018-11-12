<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\PospChannelMercInfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ChannelMerchantController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('通道商户');
            $content->description('通道商户');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增通道商户');
            $content->description('新增通道商户');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑通道商户');
            $content->description('编辑通道商户');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(PospChannelMercInfo::class, function (Form $form){
            $form->display('id','ID');
            $form->text('channel_id','通道编号');
            $form->text('merc_id','通道商户');
            $form->text('merc_name','商户名称');
            $form->text('rate_id','通道费率');
            $form->text('merc_type','业务码');
            $form->text('tranbegin_time','交易开始时间');
            $form->text('tranend_time','交易结束时间');
            $form->select('status', '状态')->options(
                config('channel.merc_status')
            );

            $form->hidden('create_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->hidden('update_by')
                ->default(Admin::user()->getAuthIdentifier());

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
        return Admin::grid(PospChannelMercInfo::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id',"ID");


            $grid->column('channel_id','通道编号');
            $grid->column('merc_id','通道商户');
            $grid->column('merc_name','商户名称');
            $grid->column('rate_id','通道费率');
            $grid->column('merc_type','业务码');
            $grid->column('tranbegin_time','交易开始时间');
            $grid->column('tranend_time','交易结束时间');
            $grid->column('status','状态')->display(function($status){
                return config('channel.merc_status.'.$status);
            })->sortable();

            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('channel_id','通道编号');
            });

        });
    }
}