<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\TeamBkgeSet;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class UserLevelController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('用户等级');
            $content->description('用户等级');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增用户等级');
            $content->description('新增用户等级');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑用户等级');
            $content->description('编辑用户等级');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(TeamBkgeSet::class, function (Form $form){
            $form->display('id', 'ID');


            $form->text('agent_id','代理编号');
            $form->text('business_code','业务编号');
            $form->text('three_rate','用户直推分润');
            $form->text('three_max_rate','用户直推附加费');
            $form->text('second_rate','用户间推分润');
            $form->text('second_max_rate','用户间推附加费');
            $form->text('first_rate','用户顶推分润');
            $form->text('first_max_rate','用户顶推附加费');


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
            $grid->column('three_rate','用户直推分润');
            $grid->column('three_max_rate','用户直推附加费');
            $grid->column('second_rate','用户间推分润');
            $grid->column('second_max_rate','用户间推附加费');
            $grid->column('first_rate','用户顶推分润');
            $grid->column('first_max_rate','用户顶推附加费');



            $grid->column('status','状态');
            $grid->column('update_time','更新时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('business_code','业务编号');
            });

        });
    }
}