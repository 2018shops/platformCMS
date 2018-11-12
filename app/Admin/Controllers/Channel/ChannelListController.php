<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctUserTariffRate;
use App\Admin\Models\PospChannelInfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ChannelListController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('通道列表');
            $content->description('通道列表');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增通道列表');
            $content->description('新增通道列表');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑通道列表');
            $content->description('编辑通道列表');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(PospChannelInfo::class, function (Form $form){
            $form->display('id', 'ID');


            $form->text('channel_id','通道编号');
            $form->text('orgs_id','机构编号');
            $form->text('channel_name','通道厂商');
            $form->text('contacts','联系人');
            $form->text('mobile','手机');
            $form->text('bean_name','通道Bean');
            $form->text('tranbegin_time','营业时间');
            $form->text('tranend_time','结束时间');
            $form->text('channel_type','通道类型');
            $form->text('priority','通道优先级');
            $form->text('request_url','通道访问URL');
            $form->text('channel_weight','通道权重');
            $form->text('app_id','AppId');


            $form->hidden('create_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->hidden('update_by')
                ->default(Admin::user()->getAuthIdentifier());

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
        return Admin::grid(PospChannelInfo::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");


            $grid->column('channel_id','通道编号');
            $grid->column('orgs_id','机构编号');
            $grid->column('channel_name','通道厂商');
            $grid->column('contacts','联系人');
            $grid->column('mobile','手机');
            $grid->column('bean_name','通道Bean');
            $grid->column('tranbegin_time','营业时间');
            $grid->column('tranend_time','结束时间');
            $grid->column('channel_type','通道类型');
            $grid->column('priority','通道优先级');
            $grid->column('request_url','通道访问URL');
            $grid->column('channel_weight','通道权重');
            $grid->column('app_id','AppId');



            $grid->column('status','状态');
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('channel_id','通道编号');
                $filter->like('channel_type','通道类型');
            });

        });
    }
}