<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\TeamBkgeSet;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class PartnerProfitController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('合伙人分润');
            $content->description('合伙人分润');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增合伙人分润');
            $content->description('新增合伙人分润');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑合伙人分润');
            $content->description('编辑合伙人分润');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(TeamBkgeSet::class, function (Form $form){
            $form->display('id', 'ID');


            $form->text('agent_id','代理编号');
            $form->text('business_code','业务编号');
            $form->text('parner','合伙人分润');
            $form->text('parner_max','合伙人附加费');


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
        return Admin::grid(TeamBkgeSet::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");


            $grid->column('agent_id','代理编号');
            $grid->column('business_code','业务编号');
            $grid->column('parner','合伙人分润');
            $grid->column('parner_max','合伙人附加费');



            $grid->column('status','状态');
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('business_code','业务编号');
            });

        });
    }
}