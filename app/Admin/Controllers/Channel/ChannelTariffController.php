<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctUserTariffRate;
use App\Admin\Models\PospChannelInfo;
use App\Admin\Models\PospChannelMercInfo;
use App\Admin\Models\PospChannelRate;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ChannelTariffController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('通道资费');
            $content->description('通道资费');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增通道资费');
            $content->description('新增通道资费');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑通道资费');
            $content->description('编辑通道资费');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(PospChannelRate::class, function (Form $form){
            $form->display('id', 'ID');


            $form->text('channel_id','通道编号');
            $form->text('cost_rate','通道成本费率');
            $form->text('cost_max_rate','通道成本附加费');
            $form->text('norm_rate','通道标准费率');
            $form->text('norm_max_rate','通道标准附加费');
            $form->text('channel_id','垫资费率');
            $form->text('advance_max_rate','垫资附加费');


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
        return Admin::grid(PospChannelRate::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");


            $grid->column('channel_id','通道编号');
            $grid->column('cost_rate','通道成本费率');
            $grid->column('cost_max_rate','通道成本附加费');
            $grid->column('norm_rate','通道标准费率');
            $grid->column('norm_max_rate','通道标准附加费');
            $grid->column('channel_id','垫资费率');
            $grid->column('advance_max_rate','垫资附加费');


            $grid->column('status','状态');
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('channel_id','通道编号');
            });

        });
    }
}